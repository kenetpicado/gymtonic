<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ServiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                Rule::unique('services')->ignore($this->id),
            ],
            'is_active' => 'required|boolean',
            'prices' => 'required|array|min:1',
            'prices.*.value' => 'integer',
            'prices.*.period' => 'nullable',
        ];
    }

    public function attributes()
    {
        return [
            'prices.*.value' => 'value',
        ];
    }
}
