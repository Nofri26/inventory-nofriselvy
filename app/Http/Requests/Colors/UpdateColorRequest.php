<?php

namespace App\Http\Requests\Colors;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateColorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'     => ['required', 'string', 'max:100', 'unique:colors,name'],
            'hex_code' => ['required', 'string', 'max:7', 'unique:colors,hex_code'],
        ];
    }
}
