<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetATreatmentStoreRequest;
use Illuminate\Http\Request;

class GetATreatmentController extends Controller
{
    // Show Contact Form
    public function create(Request $request)
    {
        return view('forms.getATreatment');
    }

    // Store Contact Form data
    public function store(GetATreatmentStoreRequest $request)
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

        return back()->with('success', 'Thank you for your treatment request, I will contact you soon.');
    }
}
