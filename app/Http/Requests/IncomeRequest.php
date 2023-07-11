<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IncomeRequest extends FormRequest
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
            'quantity' => 'required|numeric|min:1',
            'description' => 'nullable|string',
            'incomeable_id' => 'required|numeric',
            'incomeable_type' => 'required|string',
            'created_at' => 'nullable|date'
        ];
    }
}
