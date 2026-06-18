<?php

namespace App\Http\Requests\Parent;

use App\Models\Guardian;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateParentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        /** @var Guardian|null $parent */
        $parent = $this->route('parent');

        return [
            'name' => 'required|string|max:100',
            'email' => ['required', 'email', 'max:100', Rule::unique('parents', 'email')->ignore($parent?->id)],
            'phone' => ['required', 'string', 'max:20', Rule::unique('parents', 'phone')->ignore($parent?->id)],
            'address' => 'required|string',
        ];
    }
}
