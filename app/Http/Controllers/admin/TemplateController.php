<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Template;
use App\Enums\TemplateCategory;

class TemplateController extends Controller
{
    public function index() {
        return view('admin.templates');
    }

  public function create(Request $request)
{
    try {
        Template::create([
            'name' => $request->name,
            'user_id' => 1,
            'category' => $request->category,
            'document_type' => $request->document_type,
            'html_content' => $request->html_content,
        ]);

        return redirect()->back()->with('success', 'Template created successfully.');

    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to create template: ' . $e->getMessage());
    }
}

}
