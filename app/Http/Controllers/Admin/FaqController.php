<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\LandingSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FaqController extends Controller
{
    public function index(): View
    {
        $section = LandingSection::where('slug', 'faq')->first();
        return view('admin.faqs.index', [
            'faqs'    => Faq::orderBy('order')->get(),
            'section' => $section,
        ]);
    }

    public function create(): View
    {
        return view('admin.faqs.form', ['faq' => new Faq()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active', true);
        Faq::create($data);
        return redirect()->route('admin.faqs.index')->with('success', 'Pregunta creada.');
    }

    public function edit(Faq $faq): View
    {
        return view('admin.faqs.form', compact('faq'));
    }

    public function update(Request $request, Faq $faq): RedirectResponse
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active');
        $faq->update($data);
        return redirect()->route('admin.faqs.index')->with('success', 'Pregunta actualizada.');
    }

    public function destroy(Faq $faq): RedirectResponse
    {
        $faq->delete();
        return redirect()->route('admin.faqs.index')->with('success', 'Pregunta eliminada.');
    }

    public function updateSection(Request $request): RedirectResponse
    {
        $request->validate([
            'label'    => ['nullable', 'string', 'max:100'],
            'title'    => ['nullable', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:500'],
        ]);

        $section = LandingSection::where('slug', 'faq')->firstOrFail();
        $extra   = json_decode($section->extra ?? '{}', true) ?: [];
        $extra['label'] = $request->label;

        $section->update([
            'title'     => $request->title,
            'subtitle'  => $request->subtitle,
            'is_active' => $request->boolean('is_active'),
            'extra'     => json_encode($extra),
        ]);

        return redirect()->route('admin.faqs.index')->with('success', 'Encabezado actualizado.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'question' => ['required', 'string'],
            'answer'   => ['required', 'string'],
            'order'    => ['nullable', 'integer'],
        ]);
    }
}
