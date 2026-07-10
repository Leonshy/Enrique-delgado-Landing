<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingSection;
use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TestimonialController extends Controller
{
    public function index(): View
    {
        return view('admin.testimonios.index', [
            'testimonials' => Testimonial::orderBy('order')->get(),
            'section'      => LandingSection::where('slug', 'cambio')->first(),
        ]);
    }

    public function updateSection(Request $request): RedirectResponse
    {
        LandingSection::where('slug', 'cambio')->update([
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.testimonios.index')->with('success', 'Visibilidad actualizada.');
    }

    public function create(): View
    {
        return view('admin.testimonios.form', ['testimonial' => new Testimonial()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active', true);
        Testimonial::create($data);
        return redirect()->route('admin.testimonios.index')->with('success', 'Testimonio creado.');
    }

    public function edit(Testimonial $testimonio): View
    {
        return view('admin.testimonios.form', compact('testimonio'));
    }

    public function update(Request $request, Testimonial $testimonio): RedirectResponse
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active');
        $testimonio->update($data);
        return redirect()->route('admin.testimonios.index')->with('success', 'Testimonio actualizado.');
    }

    public function destroy(Testimonial $testimonio): RedirectResponse
    {
        $testimonio->delete();
        return redirect()->route('admin.testimonios.index')->with('success', 'Testimonio eliminado.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'quote'  => ['required', 'string'],
            'author' => ['nullable', 'string', 'max:200'],
            'order'  => ['nullable', 'integer'],
        ]);
    }
}
