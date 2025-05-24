<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Template;
use App\Enums\TemplateCategory;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Shared\Html;
use PhpOffice\PhpWord\SimpleType\Jc;
use HTMLPurifier;
use HTMLPurifier_Config;

class TemplateController extends Controller
{
    public function index()
    {
        return view('admin.templates');
    }
    
    public function showTemplateForm($id = null)
    {
        $template = null;

        if ($id) {
            $template = Template::findOrFail($id);
        }

        return view('admin.create-template', compact('template'));
    }


    public function create(Request $request)
    {
        try {
            Template::create([
                'name' => $request->name,
                'user_id' => Auth::id(),
                'revision' => $request->revision,
                'pages' => $request->pages,
                'revision_date' => $request->revision_date,
                'ref' => $request->ref,
                'category' => $request->category,
                'document_type' => $request->document_type,
                'content' => $request->content,
            ]);

            return redirect()->back()->with('success', 'Template created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create template: ' . $e->getMessage());
        }
    }

    
    public function templatesList(Request $request)
    {
        $templates = Template::query();
           
        if ($request->has('search')) {
            $templates->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category')) {
            $templates->where('category', $request->category);
        }

        if ($request->has('document_type')) {
            $templates->where('document_type', $request->document_type);
        }

        return response()->json($templates->get());
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
        if ($template->document_type->value == 'pdf') {
         
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
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    flex-direction: row;
                }

                .header-left {
                    flex: 1;
                    text-align: left;
                }

                .header-center {
                    flex: 1;
                    text-align: center;
                    font-weight: bold;
                    font-size: 14px;
                    position: fixed;
                    top: -60px;
                    left: 40%;
                }

                footer {
                    position: fixed;
                    bottom: -30px;
                    left: 0;
                    right: 0;
                    height: 50px;
                    font-size: 12px;
                }

                .content {
                    margin-top: 20px;
                }
            </style>
        </head>
        <body>

            <header>
                <div class="header-left">' . $imageTag . '</div>
                <div class="header-center">' . $template->ref . ' ' . $template->name . '</div>
            </header>

            <footer>
                <div style="width: 100%; font-size: 12px; display: flex; justify-content: space-between;">
                    <div style="text-align: left;">
                        Rev 3 16/04/2025<br>
                        &copy; LAMTANS &trade; 2025
                    </div>
                    <div style="text-align: right;">
                        A01 Page 
                        <script type="text/php">
                            if (isset($pdf)) {
                                echo $pdf->page_number . " of " . $pdf->page_count;
                            }
                        </script>
                    </div>
                </div>
            </footer>

            <div class="content">
                ' . $template->content . '
            </div>

        </body>
        </html>
        ';

            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html);
            
            return $pdf->download($template->name . '.pdf');
        } else if ($template->document_type->value == 'word') {


            // Enable internal error handling for malformed XML
            libxml_use_internal_errors(true);

            // Your XML content (replace with dynamic content if needed)
            $xmlContent = $template->content; // Your XML content 
            // <<<XML XML;

            // Load XML content


            // $xmlContent = $template->html_content; // Your XML content

            $xml = simplexml_load_string($xmlContent);
if ($xml === false) {
    foreach (libxml_get_errors() as $error) {
        echo "XML Error: ", $error->message, "\n";
    }
    libxml_clear_errors();
    abort(500, 'Invalid XML content provided.');
}

// Create PhpWord object
$phpWord = new PhpWord();
$section = $phpWord->addSection();

// ✅ Add Header: Image + Title in a single row using a table
$header = $section->addHeader();
$phpWord->addTableStyle('HeaderTable', ['borderSize' => 0,'borderColor'=> 'FFFFFF', 'cellMargin' => 0]);
$headerTable = $header->addTable('HeaderTable');
$headerTable->addRow();

// Column 1: Image
$imagePath = public_path('storage/' . Auth::user()->profile_pic);
if (file_exists($imagePath)) {
    $headerTable->addCell(1000, ['valign' => 'center'])->addImage($imagePath, [
        'width' => 80,
        'alignment' => Jc::LEFT,
    ]);
} else {
    Log::error('Profile image not found: ' . $imagePath);
    $headerTable->addCell(1000)->addText('');
}

// Column 2: Centered Text
$headerTable->addCell(8000, ['valign' => 'center'])->addText(
    'DOC-001 Test Document',
    ['bold' => true, 'size' => 14],
    ['alignment' => Jc::CENTER]
);

// ✅ Table style for document body
$tableStyleName = 'BorderedTable';
$phpWord->addTableStyle($tableStyleName, [
    'borderSize' => 6,
    'borderColor' => '000000',
    'cellMargin' => 80,
]);

// ✅ Recursive function to parse XML
function parseXmlToWord($xml, $section, $phpWord, $tableStyleName)
{
    foreach ($xml->children() as $element) {
        $tag = strtolower($element->getName());

        switch ($tag) {
            case 'p':
                $section->addText(trim((string)$element));
                break;

            case 'h1':
                $section->addText(trim((string)$element), ['bold' => true, 'size' => 20]);
                break;

            case 'h2':
                $section->addText(trim((string)$element), ['bold' => true, 'size' => 16]);
                break;

            case 'h3':
                $section->addText(trim((string)$element), ['bold' => true, 'size' => 14]);
                break;

            case 'ul':
            case 'ol':
                foreach ($element->li as $li) {
                    $section->addListItem(strip_tags((string)$li), 0, [], $tag === 'ol' ? 'number' : 'bullet');
                }
                break;

            case 'table':
                $table = $section->addTable($tableStyleName);

                if (isset($element->thead)) {
                    foreach ($element->thead->row as $row) {
                        $table->addRow();
                        foreach ($row->cell as $cell) {
                            $table->addCell(5000)->addText(trim((string)$cell), ['bold' => true]);
                        }
                    }
                }

                if (isset($element->tbody)) {
                    foreach ($element->tbody->row as $row) {
                        $table->addRow();
                        foreach ($row->cell as $cell) {
                            $table->addCell(5000)->addText(trim((string)$cell));
                        }
                    }
                }
                break;

            case 'note':
                $section->addText("NOTE: " . trim((string)$element), ['italic' => true, 'size' => 10]);
                break;

            case 'list':
                foreach ($element->item as $item) {
                    $section->addListItem(trim((string)$item), 0, [], 'bullet');
                }
                break;

            default:
                $text = trim((string)$element);
                if ($text !== '') {
                    $section->addText($text);
                }
        }
    }
}

// Parse the XML
parseXmlToWord($xml, $section, $phpWord, $tableStyleName);

// ✅ Footer
$footer = $section->addFooter();
$footer->addPreserveText('Page {PAGE} of {NUMPAGES}', null, ['alignment' => Jc::RIGHT]);

// ✅ Save and return file
$filename = $template->name . '.docx';
$savePath = public_path($filename);
IOFactory::createWriter($phpWord, 'Word2007')->save($savePath);
return response()->download($savePath, $filename)->deleteFileAfterSend(true);
        } else {
            abort(400, 'Unsupported document type.');
        }
    }
}
