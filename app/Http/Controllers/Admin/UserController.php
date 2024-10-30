<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;

class UserController extends Controller
{
    protected $limit = 10;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate($this->limit);
        return view('admin.users.index', [
            'users' => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ]);
        Password::sendResetLink($request->only(['email']));
        return redirect(route('admin.users.index'))->with('success', 'Utilisateur ajouté.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect(route('admin.users.index'))->with('success', 'Utilisateur mise à jour.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect(route('admin.users.index'))->with('error', 'Utilisateur supprimé.');
    }

    public function dashboard(){
        $users = User::count();
        return view('admin.users.dashboard',[
            'users'=>$users
        ]);
    }
}
