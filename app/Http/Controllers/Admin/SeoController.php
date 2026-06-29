<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeoSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SeoController extends Controller
{
    public function index(): View
    {
        $seoSettings = SeoSetting::all();
        return view('admin.seo.index', compact('seoSettings'));
    }

    public function edit(SeoSetting $seo): View
    {
        return view('admin.seo.edit', compact('seo'));
    }

    public function update(Request $request, SeoSetting $seo): RedirectResponse
    {
        $data = $request->validate([
            'meta_title'       => ['nullable', 'string', 'max:120'],
            'meta_description' => ['nullable', 'string', 'max:300'],
            'slug'             => ['nullable', 'string', 'max:150'],
            'canonical_url'    => ['nullable', 'url'],
            'og_title'         => ['nullable', 'string', 'max:120'],
            'og_description'   => ['nullable', 'string', 'max:300'],
            'og_image'         => ['nullable', 'image', 'max:2048'],
            'noindex'          => ['boolean'],
            'nofollow'         => ['boolean'],
        ]);

        if ($request->hasFile('og_image')) {
            if ($seo->og_image) Storage::disk('public')->delete($seo->og_image);
            $data['og_image'] = $request->file('og_image')->store('seo', 'public');
        }

        $data['noindex']  = $request->boolean('noindex');
        $data['nofollow'] = $request->boolean('nofollow');
        unset($data['og_image_file']);

        $seo->update($data);
        return redirect()->route('admin.seo.index')->with('success', 'SEO actualizado.');
    }
}
