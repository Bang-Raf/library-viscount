<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the kios mode interface.
     */
    public function index()
    {
        return view('kios');
    }
}
