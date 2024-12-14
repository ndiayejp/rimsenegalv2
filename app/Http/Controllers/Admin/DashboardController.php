<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\User;
use App\Models\Agency;
use App\Models\Promotion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::notDraft()->count();
        $promotions = Promotion::notDraft()->count();
        $users = User::paginate(10);
        $agencies = Agency::count();
        return view('admin.dashboard.index', compact('posts', 'promotions','users','agencies'));
    }


}
