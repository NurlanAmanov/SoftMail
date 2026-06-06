<?php

namespace App\Http\Controllers\Mailler;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TemplateController extends Controller
{
    public function index(Request $request)
    {
        $templates = EmailTemplate::latest()
            ->when(
                $request->filled('search'),
                fn($q) =>
                $q->where('name', 'like', '%' . $request->search . '%')
            )
            ->paginate(20)
            ->withQueryString();

        return view('frontend.pages.mail.template.index', compact('templates'));
    }

    public function duplicate($id)
    {
        $original = EmailTemplate::findOrFail($id);

        $copy = $original->replicate();
        $copy->name = $original->name . ' (Kopya)';
        $copy->slug = \Illuminate\Support\Str::slug($copy->name) . '-' . now()->timestamp;
        $copy->save();

        return back()->with('message', '"' . $original->name . '" şablonu kopyalandı.');
    }

    public function create()
    {
        return view('frontend.pages.mail.template.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'html_content' => 'required|string',
        ]);

        preg_match_all('/\[\[([A-Z_]+)\]\]/', $request->html_content, $matches);
        $placeholders = array_values(array_unique($matches[1]));

        EmailTemplate::create([
            'name'           => $request->name,
            'slug'           => Str::slug($request->name),
            'html_content'   => $request->html_content,
            'json_structure' => $placeholders,
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Şablon yadda saxlanıldı!',
        ]);
    }

    public function destroy($id)
    {
        EmailTemplate::findOrFail($id)->delete();
        return back()->with('message', 'Şablon silindi.');
    }
    public function edit($id)
    {
        $template = EmailTemplate::findOrFail($id);
        return view('frontend.pages.mail.template.create', compact('template'));
    }

    public function update(Request $request, $id)
    {
        $template = EmailTemplate::findOrFail($id);

        $request->validate([
            'name'         => 'required|string|max:255',
            'html_content' => 'required|string',
        ]);

        preg_match_all('/\[\[([A-Z_]+)\]\]/', $request->html_content, $matches);
        $placeholders = array_values(array_unique($matches[1]));

        $template->update([
            'name'           => $request->name,
            'slug'           => Str::slug($request->name),
            'html_content'   => $request->html_content,
            'json_structure' => $placeholders,
        ]);

        return response()->json(['status' => 'success', 'message' => 'Şablon yeniləndi!']);
    }
}
