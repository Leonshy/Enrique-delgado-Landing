<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SessionPlan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SessionPlanController extends Controller
{
    public function index(): View
    {
        return view('admin.planes.index', ['plans' => SessionPlan::orderBy('order')->get()]);
    }

    public function create(): View
    {
        return view('admin.planes.form', ['plan' => new SessionPlan()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['is_active']  = $request->boolean('is_active', true);
        $data['is_featured']= $request->boolean('is_featured');
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
        $data['is_active']  = $request->boolean('is_active');
        $data['is_featured']= $request->boolean('is_featured');
        $plan->update($data);
        return redirect()->route('admin.planes.index')->with('success', 'Plan actualizado.');
    }

    public function destroy(SessionPlan $plan): RedirectResponse
    {
        $plan->delete();
        return redirect()->route('admin.planes.index')->with('success', 'Plan eliminado.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name'        => ['required', 'string', 'max:100'],
            'subtitle'    => ['nullable', 'string', 'max:100'],
            'description' => ['required', 'string'],
            'order'       => ['nullable', 'integer'],
        ]);
    }
}
