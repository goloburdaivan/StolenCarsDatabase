<?php

namespace App\Http\Requests\Auto;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AutosSearchRequest extends FormRequest
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
            'q' => ['string'],
            'color' => ['string'],
            'sort_by' => Rule::in(array_keys($this->getSortableFields())),
            'sort_type' => Rule::in(['asc', 'desc']),
            'brand' => ['array'],
            'brand.*' => ['string'],
            'model' => ['array'],
            'model.*' => ['string'],
            'year' => ['array'],
            'year.*' => ['int'],
        ];
    }

    public function getSortableFields(): array
    {
        return [
            'id' => 'id',
            'vin_code' => 'vin_code',
            'plate_number' => 'plate_number',
            'brand' => 'brand',
            'model' => 'model',
            'year' => 'year',
            'color' => 'color',
            'name' => 'name',
            'created_at' => 'created_at',
            'updated_at',
        ];
    }
}
