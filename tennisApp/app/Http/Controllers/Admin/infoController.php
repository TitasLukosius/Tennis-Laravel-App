<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

class infoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        parent::__construct();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        dump('INFO PAGE ');
//        return view('home');
    }
}
