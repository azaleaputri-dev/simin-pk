<?php

namespace App\Http\Requests\PPDB;

use App\Services\PpdbDocumentService;
use Illuminate\Foundation\Http\FormRequest;

class PortalDocumentUploadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'document_type' => ['required', 'in:' . implode(',', PpdbDocumentService::DOCUMENT_TYPES)],
            'file' => ['required', 'file', 'max:5120', 'mimes:jpg,jpeg,png,webp,pdf'],
        ];
    }
}
