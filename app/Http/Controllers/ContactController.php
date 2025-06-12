<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Mail::send([], [], function ($message) use ($validated) {
            $message->to('contact@fingerscut.com')
                ->subject($validated['subject'])
                ->text(view('emails.contact-plain', compact('validated'))->render())
                ->replyTo($validated['email']);
        });

        return back()->with('status', 'Votre message a bien été envoyé !');
    }
}
