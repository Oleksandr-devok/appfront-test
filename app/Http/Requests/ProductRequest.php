<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|min:10',
            'description' => 'nullable|min:30',
            'price' => 'required|numeric|min:0.1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
