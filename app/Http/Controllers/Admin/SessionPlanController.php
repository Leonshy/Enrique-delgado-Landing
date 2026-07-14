<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\HtmlSanitizer;
use App\Http\Controllers\Controller;
use App\Models\LandingSection;
use App\Models\SessionPlan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SessionPlanController extends Controller
{
    public function index(): View
    {
        $section = LandingSection::where('slug', 'planes')->first();
        return view('admin.planes.index', [
            'plans'   => SessionPlan::orderBy('order')->get(),
            'section' => $section,
        ]);
    }

    public function create(): View
    {
        return view('admin.planes.form', ['plan' => new SessionPlan()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['is_active']   = $request->boolean('is_active', true);
        $data['is_featured'] = $request->boolean('is_featured');
        SessionPlan::create($data);
        return redirect()->route('admin.planes.index')->with('success', 'Plan creado.');
    }

    public function edit(SessionPlan $plan): View
    {
        return view('admin.planes.form', compact('plan'));
    }

    public function update(Request $request, SessionPlan $plan): RedirectResponse
    {
        $data = $this->validated($request);
        $data['is_active']   = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');
        $plan->update($data);
        return redirect()->route('admin.planes.index')->with('success', 'Plan actualizado.');
    }

    public function destroy(SessionPlan $plan): RedirectResponse
    {
        $plan->delete();
        return redirect()->route('admin.planes.index')->with('success', 'Plan eliminado.');
    }

    public function updateSection(Request $request): RedirectResponse
    {
        $request->validate([
            'label'    => ['nullable', 'string', 'max:100'],
            'title'    => ['nullable', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:500'],
            'footer_note' => ['nullable', 'string', 'max:300'],
        ]);

        $section = LandingSection::where('slug', 'planes')->firstOrFail();
        $extra   = json_decode($section->extra ?? '{}', true) ?: [];
        $extra['label']       = $request->label;
        $extra['footer_note'] = $request->footer_note;

        $section->update([
            'title'     => $request->title,
            'subtitle'  => $request->subtitle,
            'is_active' => $request->boolean('is_active'),
            'extra'     => json_encode($extra),
        ]);

        return redirect()->route('admin.planes.index')->with('success', 'Encabezado actualizado.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name'           => ['required', 'string', 'max:100'],
            'subtitle'       => ['nullable', 'string', 'max:200'],
            'description'    => ['nullable', 'string'],
            'price'          => ['nullable', 'string', 'max:50'],
            'period'         => ['nullable', 'string', 'max:50'],
            'cta_label'      => ['nullable', 'string', 'max:80'],
            'whatsapp_text'  => ['nullable', 'string', 'max:500'],
            'order'          => ['nullable', 'integer'],
        ]);

        $data['description'] = HtmlSanitizer::clean($data['description'] ?? '');

        return $data;
    }
}
