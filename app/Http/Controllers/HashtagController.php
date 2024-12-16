<?php

namespace App\Http\Controllers;

use App\Models\Hashtag;
use Illuminate\Http\Request;

class HashtagController extends Controller
{
    public function show($hashtag)
{
    $hashtag = Hashtag::where('name', $hashtag)->firstOrFail();
    $chirps = $hashtag->chirps()->latest()->get();

    return view('hashtag.show', compact('chirps', 'hashtag'));
}
}
