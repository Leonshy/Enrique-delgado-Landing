@extends('layouts.admin')
@section('title', 'Consultas')
@section('page-title', 'Consultas recibidas')

@section('content')
<div class="flex justify-between items-center mb-6">
    <p class="text-sm text-gray-500">{{ $messages->total() }} consultas en total</p>
    <a href="{{ route('admin.messages.export') }}" class="btn-outline text-sm py-2 px-4">
        Exportar CSV
    </a>
</div>

<div class="card overflow-hidden p-0">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Consulta</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider hidden md:table-cell">Email</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider hidden lg:table-cell">Fecha</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Estado</th>
                    <th class="px-6 py-4"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($messages as $msg)
                <tr class="border-b border-gray-50 hover:bg-gray-50 transition-colors {{ !$msg->is_read ? 'bg-blue-50/30' : '' }}">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            @if(!$msg->is_read)
                            <div class="w-2 h-2 rounded-full flex-shrink-0" style="background-color: var(--color-primary);"></div>
                            @else
                            <div class="w-2 h-2 rounded-full flex-shrink-0 bg-gray-200"></div>
                            @endif
                            <div>
                                <p class="font-medium text-sm" style="color: var(--color-brand-dark);">{{ $msg->name }}</p>
                                <p class="text-xs text-gray-400">{{ $msg->phone }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600 hidden md:table-cell">{{ $msg->email }}</td>
                    <td class="px-6 py-4 text-xs text-gray-400 hidden lg:table-cell">{{ $msg->created_at->format('d/m/Y H:i') }}</td>
                    <td class="px-6 py-4">
                        @if($msg->responded_at)
                        <span class="text-xs font-medium px-2 py-1 rounded-full bg-green-100 text-green-700">Respondida</span>
                        @elseif($msg->is_read)
                        <span class="text-xs font-medium px-2 py-1 rounded-full bg-gray-100 text-gray-600">Leída</span>
                        @else
                        <span class="text-xs font-medium px-2 py-1 rounded-full text-white" style="background-color: var(--color-primary);">Nueva</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('admin.messages.show', $msg) }}" class="text-sm font-medium" style="color: var(--color-primary);">Ver</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                        <svg class="mx-auto mb-3" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                        No hay consultas registradas.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">
    {{ $messages->links() }}
</div>
@endsection
