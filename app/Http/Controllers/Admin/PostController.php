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
        if ($request->hasFile('thumb')) {
            $post = (new FileService())->uploadImage($post, $request->file('thumb'));
        }
        Post::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'category_id' => $request->category_id,
            'content' => $request->content,
            'status' => $request->input('status') ? 1 : 0,
            'image' => $post->image,
            'user_id' => 1,
        ]);

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
        if ($request->hasFile('thumb')) {
            $post = (new FileService())->uploadImage($post, $request->file('thumb'));
        }

        $post->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'category_id' => $request->category_id,
            'content' => $request->content,
            'status' => $request->input('status') ? 1 : 0,
            'image' => $post->image,
            'user_id' => 1,
        ]);
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
