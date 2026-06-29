<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class LandingController extends Controller
{
    public function index(): View
    {
        $sections = LandingSection::orderBy('order')->get();
        return view('admin.landing.index', compact('sections'));
    }

    public function edit(LandingSection $section): View
    {
        return view('admin.landing.edit', compact('section'));
    }

    public function update(Request $request, LandingSection $section): RedirectResponse
    {
        $data = $request->validate([
            'title'     => ['nullable', 'string', 'max:255'],
            'subtitle'  => ['nullable', 'string', 'max:255'],
            'body'      => ['nullable', 'string'],
            'extra'     => ['nullable', 'string'],
            'cta_text'  => ['nullable', 'string', 'max:100'],
            'cta_url'   => ['nullable', 'string', 'max:255'],
            'image_alt' => ['nullable', 'string', 'max:255'],
            'image'     => ['nullable', 'image', 'max:4096'],
            'is_active' => ['boolean'],
        ]);

        if ($request->hasFile('image')) {
            if ($section->image_path) {
                Storage::disk('public')->delete($section->image_path);
            }
            $data['image_path'] = $request->file('image')->store("sections/{$section->slug}", 'public');
        }

        $data['is_active'] = $request->boolean('is_active');
        unset($data['image']);
        $section->update($data);

        return redirect()->route('admin.landing.index')->with('success', 'Sección actualizada.');
    }
}
