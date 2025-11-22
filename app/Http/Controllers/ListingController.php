<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    /**
     * Affiher la liste des promotions
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
      return view('properties.index');
    }

    /**
     * Afficher les promotions publiées
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function promos(){
        $promotions = Promotion::published()->get();
        return view('promotions.index', [
            'promotions'=>$promotions
        ]);
    }

    /**
     * Afficher le détail des promotions
     * @param mixed $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showPromo($slug){
        $promotion = Promotion::where('slug',$slug)->with('tags')->firstOrFail();
        return view('promotions.show', compact('promotion'));
    }

}
