<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    protected $redirect = '/login';
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'A Valid Email is Required to Login',
            'email.email' => 'Please Provide a Valid Email',
            'email.string' => 'Please Provide a Valid Email',
            'password.required' => 'Please Provide a Password',
            'password.string' => 'Please Provide a Valid Password',
            'password.min' => 'Please Provide a Valid Password',
        ];
    }
}
