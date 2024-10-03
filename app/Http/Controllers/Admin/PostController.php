<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\FileService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{
    protected $limit = 10;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with(['category'])
            ->latest()
            ->NotDraft()
            ->paginate($this->limit);
        return view('admin.posts.index', [
            'posts' => $posts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $post = Post::draft();
        return view('admin.posts.form', [
            'post' => $post,
            'categories' => Category::pluck('name', 'id'),
            'selectedValue' => $post->category_id,
            'editor' => 'trumbowyg',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request): RedirectResponse
    {

        $post = Post::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'category_id' => $request->category_id,
            'content' => $request->content,
            'status' => $request->input('status') ? 1 : 0,

            'user_id' => 1,
        ]);
        if ($file = $request->hasFile('thumb')) {
        $post
        ->addMedia($file)
        ->toMediaCollection();
        }

        return redirect('/admin/posts')->with('success', 'Article ajouté');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('admin.posts.form', [
            'post' => $post,
            'categories' => Category::pluck('name', 'id'),
            'selectedValue' => $post->category_id,
            'editor' => 'trumbowyg',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post): RedirectResponse
    {


        $post->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'category_id' => $request->category_id,
            'content' => $request->content,
            'status' => $request->input('status') ? 1 : 0,

            'user_id' => 1,
        ]);
        if ( $request->hasFile('thumb')) {
             $file = $request->file('thumb');
            $post
            ->addMedia($file)
            ->toMediaCollection();
        }
        return redirect('/admin/posts')->with('success', 'Article modifié');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if($post->image != NULl){
            $thumb = public_path("/".$post->image);
            if(file_exists($thumb)){
            unlink($thumb);
            }
        }
        $post->delete();
        return redirect('/admin/posts')->with('error', 'Article supprimé');
    }
}
