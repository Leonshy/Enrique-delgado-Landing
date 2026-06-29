<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

class MessagesController extends Controller
{
    public function index(): View
    {
        $messages = ContactMessage::recent()->paginate(15);
        return view('admin.messages.index', compact('messages'));
    }

    public function show(ContactMessage $message): View
    {
        if (!$message->is_read) {
            $message->update(['is_read' => true]);
        }
        return view('admin.messages.show', compact('message'));
    }

    public function markRead(ContactMessage $message): RedirectResponse
    {
        $message->update(['is_read' => true]);
        return back()->with('success', 'Marcada como leída.');
    }

    public function markResponded(ContactMessage $message): RedirectResponse
    {
        $message->update(['responded_at' => now(), 'is_read' => true]);
        return back()->with('success', 'Marcada como respondida.');
    }

    public function destroy(ContactMessage $message): RedirectResponse
    {
        $message->delete();
        return redirect()->route('admin.messages.index')->with('success', 'Consulta eliminada.');
    }

    public function export(): Response
    {
        $messages = ContactMessage::recent()->get();

        $csv = "ID,Nombre,Teléfono,Email,Mensaje,Leída,Respondida,Fecha\n";
        foreach ($messages as $m) {
            $csv .= implode(',', [
                $m->id,
                '"' . str_replace('"', '""', $m->name) . '"',
                '"' . $m->phone . '"',
                '"' . $m->email . '"',
                '"' . str_replace('"', '""', $m->message) . '"',
                $m->is_read ? 'Sí' : 'No',
                $m->responded_at ? $m->responded_at->format('Y-m-d H:i') : '-',
                $m->created_at->format('Y-m-d H:i'),
            ]) . "\n";
        }

        return response($csv, 200, [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="consultas-' . now()->format('Y-m-d') . '.csv"',
        ]);
    }
}
