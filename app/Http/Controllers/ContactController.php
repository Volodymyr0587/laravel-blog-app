<?php

namespace App\Http\Controllers;

use App\Mail\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function store(Request $request)
    {

        $data = $request->validate([
            'name' => 'required|string|min:2|max:256',
            'email' => 'required|email',
            'subject' => 'required|string|min:2|max:500',
            'message' => 'required|max:1000'
        ]);

        Mail::to('awesome@blog.com')->send(new Contact($data));

        return to_route('blog.contact.index')->with('status', "Thank you, we'll bs in touch soon.");
    }
}
