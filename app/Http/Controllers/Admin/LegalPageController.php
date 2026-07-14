<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\HtmlSanitizer;
use App\Http\Controllers\Controller;
use App\Models\LegalPage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LegalPageController extends Controller
{
    public function index(): View
    {
        return view('admin.legales.index', ['pages' => LegalPage::all()]);
    }

    public function edit(LegalPage $page): View
    {
        return view('admin.legales.edit', compact('page'));
    }

    public function update(Request $request, LegalPage $page): RedirectResponse
    {
        $data = $request->validate([
            'title'          => ['required', 'string', 'max:150'],
            'content'        => ['required', 'string'],
            'show_in_footer' => ['boolean'],
            'is_active'      => ['boolean'],
        ]);

        $data['content']         = HtmlSanitizer::clean($data['content']);
        $data['show_in_footer'] = $request->boolean('show_in_footer');
        $data['is_active']      = $request->boolean('is_active');
        $page->update($data);

        return redirect()->route('admin.legales.index')->with('success', 'Página legal actualizada.');
    }
}
