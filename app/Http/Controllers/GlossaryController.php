<?php

namespace App\Http\Controllers;

use App\Models\Glossary;
use Illuminate\Http\Request;

class GlossaryController extends Controller
{
    public function show($glossaryTermId){
        $glossaryTerm = Glossary::find($glossaryTermId);
        //$posts = $tag->posts()->get();

        return view('glossary.show',[
            'glossaryTerm' => $glossaryTerm,
            //'posts' => $posts,
        ]);
    }
}
