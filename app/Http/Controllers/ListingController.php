<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      return view('properties.index');
    }

    public function promos(){
        $promotions = Promotion::published()->get();
        return view('promotions.index', [
            'promotions'=>$promotions
        ]);
    }

    public function showPromo($slug){
        $promotion = Promotion::where('slug',$slug)->with('tags')->first();

        return view('promotions.show', compact('promotion'));
    }



}
