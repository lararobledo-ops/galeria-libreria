<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //
}

public function index() {
$post = "Laravel Tutorial Series One!";
return view('posts.index', ['post'=>$post])
