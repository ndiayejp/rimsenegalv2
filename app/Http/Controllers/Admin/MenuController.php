<?php

namespace App\Http\Controllers\Admin;

use App\Models\Menu;
use App\Models\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MenuController extends Controller
{
    protected $limit = 15;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.menus.index', [
            'menus' => Menu::with('children')->paginate($this->limit),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menu = new Menu();
        return view('admin.menus.form', [
            'menu' => $menu,
            'pages' => Page::pluck('title', 'id'),
            'menus' => Menu::pluck('name', 'id'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'name' => ['required'],
        ]);

        Menu::create($attributes);
        return redirect('/admin/menus')->with('success', 'Menu modifié');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {

         return view('admin.menus.form',[
            'menu'=>$menu,
            'menus'=>Menu::pluck('name','id'),
             'pages'=>Page::pluck('title','id')
         ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu)
    {
        $menu->update([
        'name'=>$request->name,
        'parent_id'=> $request->parent_id,
        'page_id'=>$request->page_id,
        'url'=>$request->url
        ]);
        return redirect('/admin/menus')->with('success','Menu modifié');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect('/admin/menus')->with('error', 'Menu supprimé');
    }
}
