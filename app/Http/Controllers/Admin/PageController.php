<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePageRequest;
use App\Http\Requests\UpdatePageRequest;

class PageController extends Controller
{
    protected $limit = 10;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pages = Page::latest()
            ->NotDraft()
            ->paginate($this->limit);
        return view('admin.pages.index', [
            'pages' => $pages,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page = Page::draft();
        return view('admin.pages.form', [
            'page' => $page,
            'editor' => 'trumbowyg',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePageRequest $request)
    {
        Page::create([
            'title' => $request->title,
            'slug' => Str::slug($request->name),
            'content' => $request->content,
            'status' => $request->input('status') ? 1 : 0,
        ]);

        return redirect('/admin/pages')->with('success', 'Page ajoutée');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $page)
    {
        return view('admin.pages.form', [
            'page' => $page,
            'editor' => 'trumbowyg',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePageRequest $request, Page $page)
    {
        $page->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'status' => $request->input('status') ? 1 : 0,
        ]);
        return redirect('/admin/pages')->with('success', 'Page modifiée');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page)
    {
       $page->delete();
       return redirect('/admin/pages')->with('error', 'Page supprimée');
    }
}
