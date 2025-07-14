<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function show()
    {
        return view('profile.show', [
            'user' => Auth::user(),
            'bookmarks' => Auth::user()->bookmarks()->with('news')->paginate(10)
        ]);
    }

    public function update(Request $request)
{
    $user = Auth::user();

    $data = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'password' => ['nullable', 'confirmed', Password::defaults()],
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($request->filled('password')) {
        $data['password'] = bcrypt($request->password);
    } else {
        unset($data['password']);
    }

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('avatars', 'public');

        if ($user->image !== 'avatars/default.png') {
            Storage::disk('public')->delete($user->image);
        }

        $data['image'] = $imagePath;
    }

    $user->update($data);

    return redirect()->route('profile.show')->with('success', 'প্রোফাইল সফলভাবে আপডেট করা হয়েছে!');
}

    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        if ($user->image !== 'avatars/default.png') {
            Storage::delete('public/'.$user->image);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'your a');
    }
}