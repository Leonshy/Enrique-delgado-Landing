<?php

namespace App\Helpers;

use enshrined\svgSanitize\Sanitizer;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageOptimizer
{
    private const MAX_WIDTH = 2000;
    private const QUALITY = 82;
    private const CONVERTIBLE = ['jpg', 'jpeg', 'png', 'webp'];

    /**
     * Reemplazo de $file->store($directory, $disk) que además:
     * - redimensiona (si hace falta) y convierte a WebP las imágenes fotográficas (jpg/png/webp).
     * - sanitiza los SVG (les saca <script>, event handlers, etc. que podrían ejecutar
     *   JavaScript si alguien abre el archivo directo en el navegador).
     * GIF, PDF y otros formatos se guardan tal cual, sin tocar.
     */
    public static function store(UploadedFile $file, string $directory, string $disk = 'public'): string
    {
        $extension = strtolower($file->getClientOriginalExtension());

        if ($extension === 'svg') {
            return static::storeSanitizedSvg($file, $directory, $disk);
        }

        if (!in_array($extension, self::CONVERTIBLE, true)) {
            return $file->store($directory, $disk);
        }

        $image = static::loadImage($file->getRealPath(), $extension);

        if (!$image) {
            return $file->store($directory, $disk);
        }

        $image = static::resizeIfNeeded($image);

        ob_start();
        imagewebp($image, null, self::QUALITY);
        $contents = ob_get_clean();
        imagedestroy($image);

        $filename = trim($directory, '/') . '/' . Str::random(40) . '.webp';
        Storage::disk($disk)->put($filename, $contents);

        return $filename;
    }

    private static function storeSanitizedSvg(UploadedFile $file, string $directory, string $disk): string
    {
        $sanitizer = new Sanitizer();
        $sanitizer->removeRemoteReferences(true);

        $clean = $sanitizer->sanitize((string) file_get_contents($file->getRealPath()));

        // Si no se pudo parsear como XML válido, no lo guardamos: es más seguro
        // rechazarlo que guardar algo potencialmente malformado/peligroso.
        if ($clean === false || trim($clean) === '') {
            throw new \RuntimeException('El archivo SVG no es válido o no se pudo procesar.');
        }

        $filename = trim($directory, '/') . '/' . Str::random(40) . '.svg';
        Storage::disk($disk)->put($filename, $clean);

        return $filename;
    }

    /** @return \GdImage|null */
    private static function loadImage(string $path, string $extension)
    {
        $image = match ($extension) {
            'jpg', 'jpeg' => @imagecreatefromjpeg($path),
            'png'         => @imagecreatefrompng($path),
            'webp'        => @imagecreatefromwebp($path),
            default       => null,
        };

        if ($image && $extension === 'png') {
            imagealphablending($image, false);
            imagesavealpha($image, true);
        }

        return $image ?: null;
    }

    /** @param \GdImage $image @return \GdImage */
    private static function resizeIfNeeded($image)
    {
        $width  = imagesx($image);
        $height = imagesy($image);

        if ($width <= self::MAX_WIDTH) {
            return $image;
        }

        $newWidth  = self::MAX_WIDTH;
        $newHeight = (int) round($height * ($newWidth / $width));

        $resized = imagecreatetruecolor($newWidth, $newHeight);
        imagealphablending($resized, false);
        imagesavealpha($resized, true);
        $transparent = imagecolorallocatealpha($resized, 0, 0, 0, 127);
        imagefilledrectangle($resized, 0, 0, $newWidth, $newHeight, $transparent);

        imagecopyresampled($resized, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        imagedestroy($image);

        return $resized;
    }
}
