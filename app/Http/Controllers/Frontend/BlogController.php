<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Blog;

class BlogController extends Controller
{
    public function index(){
        $blog = Blog::where('estado', 1)->get();
        return view('front.blog', compact('blog'));
    }
}
