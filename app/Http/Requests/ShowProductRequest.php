<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShowProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => 'required|integer|exists:products,id'
        ];
    }

    public function validationData()
    {
        return array_merge($this->all(), [
            'product_id' => $this->route('product_id')
        ]);
    }
} 