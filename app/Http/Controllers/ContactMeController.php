<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactMeStoreRequest;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Mail;

class ContactMeController extends Controller
{
    private NotificationService $notificationService;

    public function __construct(
        NotificationService $notificationService
    ) {
        $this->notificationService = $notificationService;
    }

    // Show Contact Form
    public function index(Request $request)
    {
        return view('forms.contact');
    }

    // Store Contact Form data
    public function store(ContactMeStoreRequest $request)
    {
        //  Store data in database
        //Contact::create($request->all());

        $this->notificationService->sendEmailContactMe($request->all());


        $data = $request->all();

        //  Send mail to admin
        Mail::send('mail', array(
            'name' => $data['name'],
            'surname' => $data['surname'],
            'email' => $data['email'],
            'message' => $data['message'],
        ), function ($message) use ($request) {
            $message->from($request->email);
            $message->to('digambersingh126@gmail.com', 'Admin')->subject($request->get('subject'));
        });

        return back()->with('success', 'We have received your message and would like to thank you for writing to us.');
        //return redirect('/');
    }

}