<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lastPosts = Post::latest()->with('Category')->limit(3)->published()->get();
        return view('welcome', [
            'posts' => $lastPosts,
        ]);
    }

    public function show($slug)
    {
        $page = Page::published()->where('slug', $slug)->firstOrFail();

        return view('frontend.page', compact('page'));
    }
}
