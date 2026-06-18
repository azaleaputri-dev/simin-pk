<?php

namespace App\Services;

use App\Models\PPDB;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PpdbDocumentService
{
    public const DOCUMENT_TYPES = ['kk', 'akte', 'foto'];

    public function storePortalDocument(PPDB $ppdb, string $documentType, UploadedFile $file): array
    {
        $filename = $documentType . '-' . Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('ppdb/documents', $filename, 'public');
        $documents = $ppdb->berkas ?? [];

        if (isset($documents[$documentType]['path'])) {
            Storage::disk('public')->delete($documents[$documentType]['path']);
        }

        $documents[$documentType] = [
            'path' => $path,
            'filename' => $filename,
            'original_name' => $file->getClientOriginalName(),
            'url' => Storage::disk('public')->url($path),
            'uploaded_at' => now()->toDateTimeString(),
        ];

        $ppdb->update(['berkas' => $documents]);

        return $documents[$documentType];
    }

    public function deletePortalDocument(PPDB $ppdb, string $documentType): bool
    {
        $documents = $ppdb->berkas ?? [];

        if (! isset($documents[$documentType])) {
            return false;
        }

        if (! empty($documents[$documentType]['path'])) {
            Storage::disk('public')->delete($documents[$documentType]['path']);
        }

        unset($documents[$documentType]);
        $ppdb->update(['berkas' => $documents]);

        return true;
    }

    public function storeApiDocument(UploadedFile $file): array
    {
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('ppdb/documents', $filename, 'private');

        return [
            'path' => $path,
            'filename' => $filename,
            'url' => Storage::url($path),
        ];
    }
}
