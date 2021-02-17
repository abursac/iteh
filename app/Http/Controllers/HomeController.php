<?php

namespace App\Http\Controllers;

use App\Tournament;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $tournaments = Tournament::all();
        return view('home');
    }
}
