<?php

namespace App\Http\Controllers;

use enshrined\svgSanitize\Sanitizer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Upload of the images inserted in the TinyMCE editor.
 */
class ImageUploadController
{
    /**
     * Roles allowed to upload images from the editor.
     */
    private const UPLOADER_ROLES = ['Super Admin', 'Admin', 'Post editor', 'Event editor'];

    /**
     * Accepted image extensions (keep in sync with images_file_types in resources/js/vendors/tinymce.js).
     */
    private const ALLOWED_EXTENSIONS = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg'];

    public function upload(Request $request): JsonResponse
    {
        abort_unless($request->user()?->hasAnyRole(self::UPLOADER_ROLES), 403);

        $request->validate([
            'file' => ['required', 'file', 'max:10240', 'mimes:' . implode(',', self::ALLOWED_EXTENSIONS)],
        ]);

        $file = $request->file('file');
        $extension = strtolower($file->getClientOriginalExtension());
        abort_unless(in_array($extension, self::ALLOWED_EXTENSIONS, true), 422, 'File type not allowed.');

        // Safe, unique file name: never trust the original one (path, overwrites, special chars)
        $baseName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) ?: 'image';
        $fileName = $baseName . '-' . Str::lower(Str::random(6)) . '.' . $extension;

        if ($extension === 'svg') {
            // SVG files can contain scripts: store only the sanitized markup
            $sanitizer = new Sanitizer();
            $sanitizer->removeRemoteReferences(true);
            $cleanSvg = $sanitizer->sanitize((string) file_get_contents($file->getRealPath()));

            abort_if($cleanSvg === false || $cleanSvg === '', 422, 'Invalid SVG file.');

            $path = 'uploads/' . $fileName;
            Storage::disk('public')->put($path, $cleanSvg);
        } else {
            $path = $file->storeAs('uploads', $fileName, 'public');
        }

        return response()->json(['location' => "/storage/$path"]);
    }
}
