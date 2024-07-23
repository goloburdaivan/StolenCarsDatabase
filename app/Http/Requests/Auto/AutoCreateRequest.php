<?php

namespace App\Http\Requests\Auto;

use App\Http\Requests\FormRequest;

class AutoCreateRequest extends FormRequest
{
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
            'auto.vin_code' => ['required', 'string', 'unique:autos,vin_code'],
            'auto.plate_number' => ['required', 'string'],
            'auto.color' => ['required', 'string'],
            'auto.name' => ['required', 'string'],
        ];
    }
}
