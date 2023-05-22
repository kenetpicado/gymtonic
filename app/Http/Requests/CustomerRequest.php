<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'phone' => 'nullable|numeric',
            'birth_date' => 'required|date',
            'gender' => 'required|in:M,F',
            'period' => 'required',
            'start_date' => 'required|date',
            'amount' => 'nullable',
            'discount' => 'nullable|numeric',
            'note' => 'nullable|string',
            'service_id' => 'required',
        ];
    }
}
