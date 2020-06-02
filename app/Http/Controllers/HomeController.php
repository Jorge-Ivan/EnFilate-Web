<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Venue;
use App\Turn;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function venues()
    {
        return response()->json(Venue::get());
    }

    public function index()
    {
        $turns = Turn::where('status','>',0)->orderBy('id','desc')->limit(10)->get();
        return view('turns')->with('turns',$turns);
    }
}
