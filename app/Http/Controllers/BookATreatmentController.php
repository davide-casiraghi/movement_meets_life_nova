<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookATreatmentController extends Controller
{
    // Show booking calendar
    public function create(Request $request)
    {
        return view('forms.bookATreatment');
    }

    // Show the confirmation message
    public function confirmed(Request $request)
    {
        return view('forms.bookATreatmentConfirmation');
    }

}
