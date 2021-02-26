<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetATreatmentStoreRequest;
use App\Services\NotificationService;
use Illuminate\Http\Request;

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

        $this->notificationService->sendEmailGetATreatment($request->all(), 1);

        return back()->with('success', 'Thank you for your treatment request, I will contact you soon.');
    }
}
