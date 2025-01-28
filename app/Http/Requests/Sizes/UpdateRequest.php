<?php

namespace App\Http\Requests\Sizes;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() != null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'max:50'],
            'age_from'    => ['required', 'integer', 'min:0', 'max:100'],
            'age_to'      => ['required', 'integer', 'min:0', 'max:100'],
            'description' => ['nullable', 'string'],
        ];
    }
}
