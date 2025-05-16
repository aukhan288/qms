<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Template;
use App\Enums\TemplateCategory;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

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
  public function downloadFile(Request $request)
{
    $template = Template::findOrFail($request->id);

    $imagePath = public_path('storage/' . Auth::user()->profile_pic);

    if (!file_exists($imagePath)) {
        abort(404, 'Profile image not found.');
    }

    $imageData = base64_encode(file_get_contents($imagePath));
    $mimeType = mime_content_type($imagePath);

    $imageTag = '<img src="data:' . $mimeType . ';base64,' . $imageData . '" style="max-width: 100px;" />';

    $html = '
    <html>
    <head>
        <style>
            @page {
                margin: 100px 50px 50px 50px;
            }

            body {
                font-family: sans-serif;
            }

            header {
                position: fixed;
                top: -80px;
                left: 0;
                right: 0;
                height: 80px;
                text-align: center;
            }

            .content {
                margin-top: 20px;
            }
        </style>
    </head>
    <body>

        <header>' . $imageTag . '</header>

        <div class="content">
            ' . $template->html_content . '
        </div>

    </body>
    </html>
    ';

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html);
    return $pdf->download($template->name . '.pdf');
}



}
