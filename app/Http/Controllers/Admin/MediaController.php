<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MediaAsset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MediaController extends Controller
{
    public function index(): View
    {
        $assets = MediaAsset::orderByDesc('created_at')->paginate(24);
        return view('admin.media.index', compact('assets'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'files'            => ['required', 'array', 'max:10'],
            'files.*'          => ['file', 'mimes:jpg,jpeg,png,gif,webp,svg,pdf', 'max:5120'],
            'collection'       => ['nullable', 'string', 'max:50'],
            'alt'              => ['nullable', 'string', 'max:255'],
        ]);

        foreach ($request->file('files') as $file) {
            $path = $file->store('media/' . now()->format('Y/m'), 'public');

            MediaAsset::create([
                'name'       => $file->getClientOriginalName(),
                'path'       => $path,
                'disk'       => 'public',
                'mime_type'  => $file->getMimeType(),
                'size'       => $file->getSize(),
                'alt'        => $request->input('alt', ''),
                'collection' => $request->input('collection', ''),
            ]);
        }

        return back()->with('success', 'Imagen(es) subida(s) correctamente.');
    }

    public function listJson(): \Illuminate\Http\JsonResponse
    {
        $assets = MediaAsset::orderByDesc('created_at')
            ->whereIn('mime_type', ['image/jpeg', 'image/png', 'image/webp', 'image/gif', 'image/svg+xml'])
            ->get(['id', 'name', 'path', 'disk', 'mime_type', 'alt', 'collection']);

        return response()->json($assets->map(fn($a) => [
            'id'         => $a->id,
            'name'       => $a->name,
            'path'       => $a->path,
            'url'        => Storage::disk($a->disk)->url($a->path),
            'collection' => $a->collection,
            'alt'        => $a->alt,
        ]));
    }

    public function uploadJson(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'file'       => ['required', 'file', 'mimes:jpg,jpeg,png,gif,webp,svg', 'max:5120'],
            'collection' => ['nullable', 'string', 'max:50'],
            'alt'        => ['nullable', 'string', 'max:255'],
        ]);

        $file  = $request->file('file');
        $path  = $file->store('media/' . now()->format('Y/m'), 'public');

        $asset = MediaAsset::create([
            'name'       => $file->getClientOriginalName(),
            'path'       => $path,
            'disk'       => 'public',
            'mime_type'  => $file->getMimeType(),
            'size'       => $file->getSize(),
            'alt'        => $request->input('alt', ''),
            'collection' => $request->input('collection', 'hero'),
        ]);

        return response()->json([
            'id'         => $asset->id,
            'name'       => $asset->name,
            'path'       => $asset->path,
            'url'        => $asset->url,
            'collection' => $asset->collection,
            'alt'        => $asset->alt,
        ]);
    }

    public function destroy(MediaAsset $asset): RedirectResponse
    {
        Storage::disk($asset->disk)->delete($asset->path);
        $asset->delete();
        return back()->with('success', 'Imagen eliminada.');
    }
}
