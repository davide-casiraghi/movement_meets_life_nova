<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactMeStoreRequest;
use App\Mail\ContactMeAutoResponse;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

        $data = $request->all();

        $this->notificationService->sendEmailContactMe($data, 1);

        // Send automatic response to client
        Mail::to($data['email'])->send(new ContactMeAutoResponse($data));

        return back()->with('success', 'We have received your message and would like to thank you for writing to us.');
        //return redirect('/');
    }

}
