<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function documents($category)
    {

        $title = ucwords($category);
        $documents = Template::where('category', $category)->get();
        dd($documents);
        return view('user.documents',compact('title'));

    }
}
