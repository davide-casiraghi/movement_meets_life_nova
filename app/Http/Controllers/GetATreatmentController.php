<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetATreatmentStoreRequest;
use App\Mail\GetATreatmentAutoResponse;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class GetATreatmentController extends Controller
{
    private NotificationService $notificationService;

    public function __construct(
        NotificationService $notificationService
    ) {
        $this->notificationService = $notificationService;
    }

    // Show Contact Form
    public function create(Request $request)
    {
        return view('forms.getATreatment');
    }

    // Store Contact Form data
    public function store(GetATreatmentStoreRequest $request)
    {
        //dd($request->all());
        //  Store data in database
        //Contact::create($request->all());

        $data = $request->all();

        // Send notification to the website owner
        $this->notificationService->sendEmailGetATreatment($data, 1);

        // Send automatic response to client
        //Mail::to($recipient)->send(new OrderShipped($order));

        Mail::to($data['email'])->send(new GetATreatmentAutoResponse($data));

        return back()->with('success', 'Thank you for your treatment request, I will contact you soon.');
    }
}
