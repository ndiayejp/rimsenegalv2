<?php

namespace App\Http\Controllers\Admin;

use App\Models\Promotion;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PromotionController extends Controller
{
    protected $limit = 10;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $promotions = Promotion::NotDraft()->paginate($this->limit);
        return view('admin.promotions.index', compact('promotions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $promotion = Promotion::draft();
        $datas = $promotion->tags->pluck('name');
        $tags = '';
        if (count($datas) > 0) {
            foreach ($datas as $data) {
                $result[] = $data;
            }
            $tags = implode(',', $result);
        }

        return view('admin.promotions.form', [
            'promotion' => $promotion,
            'editor' => 'trumbowyg',
            'tags' => $tags,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $promotion = Promotion::create([
            'title' => $request->title,
            'slug'=> Str::slug($request->title),
            'content' => $request->content,
            'status' => $request->input('status') ? 1 : 0,
        ]);
        if ($request->tags) {
            $tags = explode(',', $request->tags);
            $promotion->attachTags($tags);
        }
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $promotion->addMedia($file)->toMediaCollection();
        }
        if ($request->hasFile('plan')) {
            $pdf = $request->file('plan');
            $promotion->addMedia($pdf)->toMediaCollection('pdfs');
        }
        return redirect('/admin/promotions')->with('success', 'Promotion ajoutée');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Promotion $promotion)
    {
        $datas = $promotion->tags->pluck('name');
       $result = [];
        foreach ($datas as $data) {
            $result[] = $data;
        }

            $tags = !empty($result) ? implode(',', $result) : '';


        return view('admin.promotions.form', [
            'promotion' => $promotion,
            'editor' => 'trumbowyg',
            'tags' => $tags,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Promotion $promotion)
    {

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'status' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'plan' => 'nullable|mimes:pdf|max:10000',
        ]);
        $promotion->update([
            'title' => $request->title,
            'slug'=> Str::slug($request->title),
            'content' => $request->content,
            'status' => $request->input('status') ? 1 : 0,
        ]);
        if ($request->tags) {
            $tags = explode(',', $request->tags);
            $promotion->syncTags($tags);
        }
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $promotion->addMedia($file)->toMediaCollection();
        }
        if ($request->hasFile('plan')) {
            $pdf = $request->file('plan');
            $promotion->addMedia($pdf)->toMediaCollection('pdfs');
        }
        if ($request->hasFile('images')) {
            foreach ($request->images as $image) {
                $promotion->addMedia($image)->toMediaCollection('galerie');
            }
        }
        return redirect('/admin/promotions')->with('success', 'Promotion ajoutée');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Promotion $promotion)
    {
        $promotion->delete();
        return redirect('/admin/promotions')->with('success', 'Promotion supprimée');
    }

    public function deleteMedia(Promotion $promotion, $mediaId)
    {
        $media = $promotion->getMedia('galerie')->where('id', $mediaId)->first();
        if ($media) {
            $media->delete();
        }
        return response()->json(['success' => true], 200);
    }
}
