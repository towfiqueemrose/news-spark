<?php

// app/Http/Livewire/SearchNews.php

namespace App\Livewire;

use Livewire\Component;
use App\Models\News;

class SearchNews extends Component
{
    public $query = '';
    public $results = [];

    public function updatedQuery()
    {
        $this->results = News::where('title', 'like', '%' . $this->query . '%')
            ->orWhere('body', 'like', '%' . $this->query . '%')
            ->take(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.search-news');
    }
}
