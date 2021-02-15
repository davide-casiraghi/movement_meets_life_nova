<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticPageController extends Controller
{
    /**
     * Show the treatments page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function treatments()
    {
        return view('pages.treatments');
    }

    /**
     * Show the Contact Improvisation page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function contactImprovisation()
    {
        return view('pages.contactImprovisation');
    }
}
