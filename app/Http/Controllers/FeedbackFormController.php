<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FeedbackFormController extends Controller
{
    // Show Contact Form
    public function index(Request $request) {
        return view('feedback');
    }
}
