<?php

namespace App\Http\Controllers;

use App\Models\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(hasRole('admin')){
            return view('admin.dashboard');
        } elseif (hasRole('user' )) {
            $newsletters = Newsletter::get();

    return view('user.home', compact('newsletters'));
        } 
        abort(403, 'Unauthorized');
    }
}
