<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Template;

class UserDashboardController extends Controller
{
    public function index(){
$newsletters = Template::where('category', TemplateCategory::Newsletters->value)->get();

    return view('user.home', compact('newsletters'));
    }
}
