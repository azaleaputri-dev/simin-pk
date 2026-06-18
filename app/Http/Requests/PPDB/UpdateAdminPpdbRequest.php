<?php

namespace App\Http\Requests\PPDB;

use App\Models\PPDB;
use App\Services\PpdbValidationService;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminPpdbRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        /** @var PPDB|null $ppdb */
        $ppdb = $this->route('ppdb');

        return app(PpdbValidationService::class)->adminRules($this, $ppdb);
    }
}
