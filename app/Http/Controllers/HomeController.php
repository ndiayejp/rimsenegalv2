<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    /**
     * Summary of index
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $lastPosts = Post::latest()->with('Category')->limit(4)->published()->get();
        return view('welcome', [
            'posts' => $lastPosts,
        ]);
    }

    /**
     * Summary of show
     * @param mixed $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($slug)
    {
        $categories = Category::all();
        $page = Page::published()->where('slug', $slug)->firstOrFail();
        return view('frontend.page', compact('page', 'categories'));
    }

    /**
     * Summary of sendContactForm
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendContactForm(Request $request){
        $validated = $request->validate([
            'property_id' => 'required',
            'reference'=>'required',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
            'category'=>'required',
            'location'=>'required',
            'price'=>'required',
            'agent_email' => 'required|email',
        ]);
        Mail::to($validated['agent_email'])->send(new \App\Mail\ContactAgency($validated));
         return response()->json(['message' => 'Message envoyé avec succès !']);
    }
}
