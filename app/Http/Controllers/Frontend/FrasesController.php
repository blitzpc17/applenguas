<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use \App\Models\Frase;

class FrasesController extends Controller
{
    public function index(){
        $frases = Frase::get();
        return view('front.frases', compact('frases'));
    }
}
