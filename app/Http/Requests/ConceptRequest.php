<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConceptRequest extends FormRequest
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
            'name' => 'required',
            'has_income' => 'required|boolean',
            'notify_income' => 'required|boolean',
            'has_expenditure' => 'required|boolean',
            'notify_expenditure' => 'required|boolean',
        ];
    }
}
