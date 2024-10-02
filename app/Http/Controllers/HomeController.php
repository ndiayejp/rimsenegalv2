<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       return view('welcome');
    }

    public function show($slug){
        $page = Page::published()->where('slug', $slug)->firstOrFail();

        return view('frontend.page', compact('page'));
    }


}
