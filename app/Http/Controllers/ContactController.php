<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $agencies = Agency::all();
        return view('contact.index',compact('agencies'));
    }



    /**
     * contact form
     */
    public function submitContactForm(Request $request)
    {
       $validatedData = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email|max:255',
            'objet' => 'required|string|min:3|max:255',
            'content' => 'required|string|min:10',
       ]);

       try {
            Mail::to('ndiayejp@gmail.com') // Adresse de réception
            ->send(new \App\Mail\ContactUsMail($validatedData));

            return redirect()->back()->with('success', 'Votre message a été envoyé avec succès.');
       } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error', 'Une erreur est survenue. Veuillez réessayer.');
       }
    }



}
