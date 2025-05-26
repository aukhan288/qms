<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function documents($category)
    {

        $title = ucwords($category);
        $documents = Template::where('category', $category)->get('id','ref','name', 'document_type','category', 'revision','pages','revision_date');
        
        return view('user.documents',compact('title','documents'));

    }
}
