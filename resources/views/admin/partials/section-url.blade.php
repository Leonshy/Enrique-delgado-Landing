@php($sectionUrl = route('home') . '#' . $anchor)
<div class="flex items-center gap-2 mb-6 p-3 rounded-xl text-sm" style="background:var(--color-brand-muted);">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--color-primary);flex-shrink:0;">
        <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/>
        <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>
    </svg>
    <input type="text" readonly value="{{ $sectionUrl }}" onclick="this.select()"
           id="section-url-{{ $anchor }}"
           class="flex-1 bg-transparent border-0 text-xs font-mono focus:outline-none min-w-0" style="color:var(--color-brand-dark);">
    <button type="button" class="btn-outline text-xs shrink-0" onclick="copySectionUrl('{{ $anchor }}', this)">Copiar URL</button>
</div>
