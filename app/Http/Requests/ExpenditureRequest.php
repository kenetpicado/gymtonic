<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpenditureRequest extends FormRequest
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
            'value' => 'required|numeric|gt:0',
            'concept' => 'required|string',
            'description' => 'nullable|string',
            'expenditureable_id' => 'required|numeric',
            'expenditureable_type' => 'required|string',
            'created_at' => 'nullable|date'
        ];
    }
}
