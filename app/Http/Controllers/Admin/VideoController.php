<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\HtmlSanitizer;
use App\Http\Controllers\Controller;
use App\Models\LandingSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VideoController extends Controller
{
    public function edit(): View
    {
        $section = LandingSection::firstOrCreate(
            ['slug' => 'video'],
            ['title' => 'Mirá cómo trabajo', 'is_active' => true, 'order' => 6]
        );
        $extra = json_decode($section->extra ?? '{}', true) ?: [];

        return view('admin.video.edit', compact('section', 'extra'));
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'label'     => ['nullable', 'string', 'max:100'],
            'title'     => ['nullable', 'string', 'max:255'],
            'subtitle'  => ['nullable', 'string', 'max:500'],
            'video_url' => ['nullable', 'string', 'max:500'],
        ]);

        $section = LandingSection::where('slug', 'video')->firstOrFail();

        $section->update([
            'title'     => $request->title,
            'subtitle'  => HtmlSanitizer::clean($request->subtitle),
            'is_active' => $request->boolean('is_active'),
            'extra'     => json_encode([
                'label'     => $request->label,
                'video_url' => $request->video_url,
            ]),
        ]);

        return redirect()->route('admin.video.edit')->with('success', 'Sección Video actualizada.');
    }
}
