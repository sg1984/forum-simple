<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $threads = Thread::latest()->paginate(20);
        $categories = Thread::getAllCategories();

        return view('threads.index', compact('threads', 'categories'));
    }
}