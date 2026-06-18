<?php

namespace App\Http\Requests\PPDB;

use App\Services\PpdbValidationService;
use Illuminate\Foundation\Http\FormRequest;

class PublicPpdbRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return app(PpdbValidationService::class)->publicRules($this);
    }
}
