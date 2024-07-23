<?php

namespace App\Http\Requests\Auto;

use App\Http\Requests\FormRequest;

class AutoUpdateRequest extends FormRequest
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
            'auto.vin_code' => ['string', 'unique:autos,vin_code'],
            'auto.plate_number' => ['string'],
            'auto.color' => ['string'],
            'auto.name' => ['string'],
        ];
    }
}
