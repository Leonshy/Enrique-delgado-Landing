@extends('layouts.admin')
@section('title', 'SEO — ' . $seo->page)
@section('page-title', 'SEO: ' . $seo->page)

@section('content')
<div class="max-w-2xl">
    <div class="mb-4">
        <a href="{{ route('admin.seo.index') }}" class="text-sm flex items-center gap-2" style="color: var(--color-primary);">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
            Volver
        </a>
    </div>
    <form method="POST" action="{{ route('admin.seo.update', $seo) }}" enctype="multipart/form-data" class="card space-y-5">
        @csrf @method('PUT')

        <div>
            <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Meta title <span class="text-xs text-gray-400">(máx 120 chars)</span></label>
            <input type="text" name="meta_title" value="{{ old('meta_title', $seo->meta_title) }}" maxlength="120" class="input-field">
        </div>
        <div>
            <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Meta description <span class="text-xs text-gray-400">(máx 300 chars)</span></label>
            <textarea name="meta_description" rows="3" maxlength="300" class="input-field">{{ old('meta_description', $seo->meta_description) }}</textarea>
        </div>
        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Slug / URL canónica</label>
                <input type="text" name="slug" value="{{ old('slug', $seo->slug) }}" class="input-field">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">Canonical URL</label>
                <input type="url" name="canonical_url" value="{{ old('canonical_url', $seo->canonical_url) }}" class="input-field">
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">OG Title</label>
            <input type="text" name="og_title" value="{{ old('og_title', $seo->og_title) }}" maxlength="120" class="input-field">
        </div>
        <div>
            <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">OG Description</label>
            <textarea name="og_description" rows="2" maxlength="300" class="input-field">{{ old('og_description', $seo->og_description) }}</textarea>
        </div>
        <div>
            <label class="block text-sm font-medium mb-2" style="color: var(--color-brand-dark);">OG Image</label>
            @if($seo->og_image)
            <div class="mb-2"><img src="{{ asset('storage/'.$seo->og_image) }}" class="h-24 rounded-lg object-cover"></div>
            @endif
            <input type="file" name="og_image" accept="image/*" class="input-field py-2">
        </div>
        <div class="flex gap-6">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="noindex" value="1" {{ $seo->noindex ? 'checked' : '' }}
                       class="w-4 h-4" style="accent-color: var(--color-primary);">
                <span class="text-sm font-medium" style="color: var(--color-brand-dark);">noindex</span>
            </label>
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="nofollow" value="1" {{ $seo->nofollow ? 'checked' : '' }}
                       class="w-4 h-4" style="accent-color: var(--color-primary);">
                <span class="text-sm font-medium" style="color: var(--color-brand-dark);">nofollow</span>
            </label>
        </div>
        <div class="flex gap-4">
            <button type="submit" class="btn-primary">Guardar</button>
            <a href="{{ route('admin.seo.index') }}" class="btn-outline">Cancelar</a>
        </div>
    </form>
</div>
@endsection
