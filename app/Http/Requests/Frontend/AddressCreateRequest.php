<?php

namespace App\Http\Requests\frontend;

use Illuminate\Foundation\Http\FormRequest;

class AddressCreateRequest extends FormRequest
{
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
            'first_name' => ['required','max:255'],
            'last_name' => ['nullable','max:255'],
            'area' => ['required', 'integer'],
            'email' => ['required','email','max:255'],
            'phone' => ['required','max:255'],
            'address' => ['required'],
            'type' => ['required', 'in:home,office']
        ];
    }
}
