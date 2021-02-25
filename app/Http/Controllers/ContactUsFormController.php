<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentStoreRequest;
use Illuminate\Http\Request;
use App\Models\Contact;
use Mail;
use Illuminate\Support\Facades\Validator;

class ContactUsFormController extends Controller
{
    // Show Contact Form
    public function index(Request $request)
    {
        return view('forms.contact');
    }

    // Store Contact Form data
    public function store(CommentStoreRequest $request)
    {
        //  Store data in database
        Contact::create($request->all());

        //  Send mail to admin
        Mail::send('mail', array(
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'subject' => $request->get('subject'),
            'user_query' => $request->get('message'),
        ), function($message) use ($request){
            $message->from($request->email);
            $message->to('digambersingh126@gmail.com', 'Admin')->subject($request->get('subject'));
        });

        return back()->with('success', 'We have received your message and would like to thank you for writing to us.');
        //return redirect('/');
    }

}