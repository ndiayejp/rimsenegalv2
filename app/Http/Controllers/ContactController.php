<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Summary of index
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $agencies = Agency::all();
        return view('contact.index',compact('agencies'));
    }



    /**
     * Summary of submitContactForm
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
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
            Mail::to('leonie.bandiaky@rimsenegal.com') // Adresse de réception
            ->send(new \App\Mail\ContactUsMail($validatedData));

            return redirect()->back()->with('success', 'Votre message a été envoyé avec succès.');
       } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue. Veuillez réessayer.');
       }
    }

}
