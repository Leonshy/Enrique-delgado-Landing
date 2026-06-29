<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FaqController extends Controller
{
    public function index(): View
    {
        return view('admin.faqs.index', ['faqs' => Faq::orderBy('order')->get()]);
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

    private function validated(Request $request): array
    {
        return $request->validate([
            'question' => ['required', 'string'],
            'answer'   => ['required', 'string'],
            'order'    => ['nullable', 'integer'],
        ]);
    }
}
