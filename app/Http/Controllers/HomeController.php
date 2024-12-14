<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lastPosts = Post::latest()->with('Category')->limit(4)->published()->get();
        return view('welcome', [
            'posts' => $lastPosts,
        ]);
    }

    public function show($slug)
    {
        $page = Page::published()->where('slug', $slug)->firstOrFail();

        return view('frontend.page', compact('page'));
    }

    public function sendContactForm(Request $request){
        $validated = $request->validate([
            'property_id' => 'required',
            'reference'=>'required',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
            'category'=>'required',
            'location'=>'required',
            'price'=>'required'
        ]);
        Mail::to('ndiayejp@gmail.com')->send(new \App\Mail\ContactAgency($validated));
         return response()->json(['message' => 'Message envoyé avec succès !']);
    }
}
