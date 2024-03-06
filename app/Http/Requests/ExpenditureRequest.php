<?php

namespace App\Http\Requests;

use App\Models\Concept;
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

    public function prepareForValidation()
    {
        $this->merge([
            'expenditureable_id' => $this->model_id,
            'expenditureable_type' => Concept::class
        ]);
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
            'concept' => 'required_without:expenditureable_id',
            'quantity' => 'required|numeric|min:1',
            'description' => 'nullable|string',
            'expenditureable_id' => 'nullable|numeric',
            'expenditureable_type' => 'nullable|string',
            'created_at' => 'nullable|date',
        ];
    }
}
