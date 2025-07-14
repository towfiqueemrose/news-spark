<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Cloudinary\Cloudinary;
use Cloudinary\Transformation\Resize;
use Cloudinary\Api\Upload\UploadApi;

class NewsController extends Controller
{
    private $cloudinary;

    public function __construct()
    {
        $this->cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                'api_key' => env('CLOUDINARY_API_KEY'),
                'api_secret' => env('CLOUDINARY_API_SECRET'),
            ],
        ]);
    }

    public function index()
    {
        $newsList = News::with('category')->latest()->get();
        return view('admin.dashboard', compact('newsList'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.create-news', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:news',
            'body' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'video' => 'nullable|mimetypes:video/mp4,video/quicktime,video/x-msvideo,video/x-flv,video/x-matroska|max:102400',
            'category_id' => 'required',
        ]);

        // Handle image upload to Cloudinary
        $imageUrl = null;
        if ($request->hasFile('image')) {
            try {
                $image = $request->file('image');
                $imageName = 'news_image_' . time() . '_' . Str::random(10);
                
                $uploadApi = new UploadApi();
                $result = $uploadApi->upload($image->getPathname(), [
                    'public_id' => $imageName,
                    'folder' => 'news-spark/news-images',
                    'resource_type' => 'image',
                    'overwrite' => true,
                    'transformation' => [
                        'quality' => 'auto:best',
                        'fetch_format' => 'auto'
                    ]
                ]);

                $imageUrl = $result['secure_url'];
            } catch (\Exception $e) {
                return back()->withErrors(['image' => 'Image upload failed: ' . $e->getMessage()]);
            }
        }

        // Handle video upload to Cloudinary
        $videoUrl = null;
        if ($request->hasFile('video')) {
            try {
                $video = $request->file('video');
                $videoName = 'news_video_' . time() . '_' . Str::random(10);
                
                $uploadApi = new UploadApi();
                $result = $uploadApi->upload($video->getPathname(), [
                    'public_id' => $videoName,
                    'folder' => 'news-spark/news-videos',
                    'resource_type' => 'video',
                    'overwrite' => true,
                ]);

                $videoUrl = $result['secure_url'];
            } catch (\Exception $e) {
                return back()->withErrors(['video' => 'Video upload failed: ' . $e->getMessage()]);
            }
        }

        News::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'body' => $request->body,
            'image' => $imageUrl,
            'video' => $videoUrl,
            'category_id' => $request->category_id,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'News created successfully!');
    }

    public function edit($id)
    {
        $news = News::findOrFail($id);
        $categories = Category::all();
        return view('admin.edit-news', compact('news', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $news = News::findOrFail($id);

        $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:news,slug,' . $id,
            'body' => 'required',
            'category_id' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'video' => 'nullable|mimetypes:video/mp4,video/quicktime,video/x-msvideo,video/x-flv,video/x-matroska|max:102400',
        ]);

        // Update image if new one is uploaded
        $imageUrl = $news->image;
        if ($request->hasFile('image')) {
            try {
                $image = $request->file('image');
                $imageName = 'news_image_' . time() . '_' . Str::random(10);
                
                $uploadApi = new UploadApi();
                $result = $uploadApi->upload($image->getPathname(), [
                    'public_id' => $imageName,
                    'folder' => 'news-spark/news-images',
                    'resource_type' => 'image',
                    'overwrite' => true,
                    'transformation' => [
                        'quality' => 'auto:best',
                        'fetch_format' => 'auto'
                    ]
                ]);

                $imageUrl = $result['secure_url'];
            } catch (\Exception $e) {
                return back()->withErrors(['image' => 'Image upload failed: ' . $e->getMessage()]);
            }
        }

        // Upload new video to Cloudinary
        $videoUrl = $news->video;
        if ($request->hasFile('video')) {
            try {
                $video = $request->file('video');
                $videoName = 'news_video_' . time() . '_' . Str::random(10);
                
                $uploadApi = new UploadApi();
                $result = $uploadApi->upload($video->getPathname(), [
                    'public_id' => $videoName,
                    'folder' => 'news-spark/news-videos',
                    'resource_type' => 'video',
                    'overwrite' => true,
                ]);

                $videoUrl = $result['secure_url'];
            } catch (\Exception $e) {
                return back()->withErrors(['video' => 'Video upload failed: ' . $e->getMessage()]);
            }
        }

        $news->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'body' => $request->body,
            'image' => $imageUrl,
            'video' => $videoUrl,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'News updated successfully!');
    }

    public function destroy($id)
    {
        $news = News::findOrFail($id);

        // Delete image from Cloudinary if exists
        if ($news->image) {
            try {
                // Extract public_id from Cloudinary URL
                $imageUrl = $news->image;
                $urlParts = parse_url($imageUrl);
                $pathParts = explode('/', $urlParts['path']);
                
                // Find the public_id (usually after /image/upload/)
                $uploadIndex = array_search('upload', $pathParts);
                if ($uploadIndex !== false && isset($pathParts[$uploadIndex + 1])) {
                    $publicIdWithExt = implode('/', array_slice($pathParts, $uploadIndex + 1));
                    $publicId = pathinfo($publicIdWithExt, PATHINFO_FILENAME);
                    
                    // Delete from Cloudinary
                    $uploadApi = new UploadApi();
                    $uploadApi->destroy($publicId, ['resource_type' => 'image']);
                }
            } catch (\Exception $e) {
                // Log error but don't fail the deletion
                \Log::error('Failed to delete image from Cloudinary: ' . $e->getMessage());
            }
        }

        // Delete video from Cloudinary if exists
        if ($news->video) {
            try {
                // Extract public_id from Cloudinary URL
                $videoUrl = $news->video;
                $urlParts = parse_url($videoUrl);
                $pathParts = explode('/', $urlParts['path']);
                
                // Find the public_id (usually after /video/upload/)
                $uploadIndex = array_search('upload', $pathParts);
                if ($uploadIndex !== false && isset($pathParts[$uploadIndex + 1])) {
                    $publicIdWithExt = implode('/', array_slice($pathParts, $uploadIndex + 1));
                    $publicId = pathinfo($publicIdWithExt, PATHINFO_FILENAME);
                    
                    // Delete from Cloudinary
                    $uploadApi = new UploadApi();
                    $uploadApi->destroy($publicId, ['resource_type' => 'video']);
                }
            } catch (\Exception $e) {
                // Log error but don't fail the deletion
                \Log::error('Failed to delete video from Cloudinary: ' . $e->getMessage());
            }
        }

        $news->delete();

        return back()->with('success', 'News deleted!');
    }
}