<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Template;
use App\Enums\TemplateCategory; 

class HomeController extends Controller
{
    public function home(){
        $newsletters = Template::where('category', TemplateCategory::Newsletters->value)->get(['id','name']);

    return view('user.home', compact('newsletters'));
    }
}
