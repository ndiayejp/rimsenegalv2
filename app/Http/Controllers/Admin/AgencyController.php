<?php

namespace App\Http\Controllers\admin;

use App\Models\Agency;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AgencyController extends Controller
{
    protected $limit = 10;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $agencies = Agency::paginate($this->limit);
       return view('admin.agencies.index',compact('agencies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $agency = new Agency();
        return view('admin.agencies.form', compact('agency'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string',
        ]);
        Agency::create($validated);
        return redirect('/admin/agencies')->with('success','Agence ajoutée avec succés');
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $agency = Agency::findOrFail($id);
        return view('admin.agencies.form',compact('agency'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       $validated = $request->validate([
        'name' => 'required|string',
        'address' => 'required|string',
        'phone' => 'required|string',
       ]);
        $agency = Agency::findOrFail($id);
        $agency->update($validated);
        return redirect('/admin/agencies')->with('success','Agence mise à jour.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $agency = Agency::findOrFail($id);
        $agency->delete();
        return redirect('/admin/agencies')->with('error', 'Agence supprimée avec succès.');
    }
}
