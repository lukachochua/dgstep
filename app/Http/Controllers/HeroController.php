<?php

namespace App\Http\Controllers;

use App\Models\HeroSlide;
use Illuminate\Http\Request;

class HeroController extends Controller
{
    public function index()
    {
        $slides = HeroSlide::all();

        return view('pages.home', compact('slides'));
    }
}
