<?php

namespace App\Services;

class ParentDataService
{
    public function normalize(array $validated): array
    {
        return [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'father_name' => $validated['name'],
            'mother_name' => $validated['name'],
        ];
    }
}
