<?php

namespace App\Livewire;

use Livewire\Component;
use App\Mail\ContactUsMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class ContactForm extends Component
{
    public $name;
    public $email;
    public $content;
    public $objet;


    public function render()
    {
        return view('livewire.contact-form');
    }

    protected $rules = [
        'name' => 'required|string|min:3',
        'email' => 'required|email',
        'objet' => 'required|string|min:3',
        'content' => 'required'
    ];

    public function updated($propertyName){
        $this->validateOnly($propertyName);
    }

    public function send(){

        $validatedDatas = $this->validate();
        try {
           Mail::to('support@rimsenegal.com')->send(new ContactUsMail($validatedDatas));
           Session::flash('success', 'Votre message a été envoyé');
        } catch (\Throwable $e) {
            Session::flash('error', "Problème avec l'envoi du mail.".$e->getMessage());
        }
        $this->reset();
    }
}
