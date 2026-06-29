<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProcessStep;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProcessStepController extends Controller
{
    public function index(): View
    {
        return view('admin.proceso.index', ['steps' => ProcessStep::orderBy('order')->get()]);
    }

    public function create(): View
    {
        return view('admin.proceso.form', ['step' => new ProcessStep()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active', true);
        ProcessStep::create($data);
        return redirect()->route('admin.proceso.index')->with('success', 'Paso creado.');
    }

    public function edit(ProcessStep $step): View
    {
        return view('admin.proceso.form', compact('step'));
    }

    public function update(Request $request, ProcessStep $step): RedirectResponse
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active');
        $step->update($data);
        return redirect()->route('admin.proceso.index')->with('success', 'Paso actualizado.');
    }

    public function destroy(ProcessStep $step): RedirectResponse
    {
        $step->delete();
        return redirect()->route('admin.proceso.index')->with('success', 'Paso eliminado.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'step_number' => ['required', 'integer'],
            'title'       => ['required', 'string', 'max:150'],
            'description' => ['required', 'string'],
            'order'       => ['nullable', 'integer'],
        ]);
    }
}
