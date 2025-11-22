<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    protected $limit = 8;
    /**
     * Summary of index
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
         $categories = Category::all();
        if(isset(request()->keywords)){
        $words = trim(request()->keywords);
        $posts = Post::notDraft()->where('name','LIKE','%'.$words.'%')
        ->orWhere('content','LIKE','%'.$words.'%')->latest()->paginate($this->limit);
        }elseif(isset(request()->category)){
        $category = request()->category;
        $posts =
        Category::where('slug',$category)->firstOrFail()->posts()->paginate($this->limit)->withQueryString();
        } else {
             $posts = Post::notDraft()->published()->paginate($this->limit);
        }
        return view('blog.index', compact('posts','categories'));
    }


    /**
     * Summary of show
     * @param string $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(string $slug)
    {
        $post = Post::where('slug',$slug)->first();
        $categories = Category::all();
        $mightAlsoLike = Post::notDraft()->where('slug','!=',$post->slug)->MightAlsoLike()->get();
        $previous = Post::notDraft()->where('id', '<', $post->id)->orderBy('id','desc')->first();
        $next = Post::notDraft()->where('id', '>', $post->id)->orderBy('id','desc')->first();
        if(!$post){
            return redirect('posts.index')->with('error', 'aucun article trouvé');
        }
        return view('blog.show', compact('post', 'categories', 'mightAlsoLike','previous','next'));
    }
}
