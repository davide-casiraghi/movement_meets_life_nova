<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function show($tagId){
        $tag = Tag::find($tagId);
        $posts = $tag->posts()->get();

        return view('tags.show',[
            'tag' => $tag,
            'posts' => $posts,
        ]);
    }
}
