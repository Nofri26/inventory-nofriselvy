<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

/**
 *
 */
class LoginRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'min:8', 'max:100', 'regex:/^[a-zA-Z0-9]+$/', 'exists:users,username'],
            'password' => ['required', 'string', 'min:8', 'max:100'],
        ];
    }

    /**
     * @param $validator
     * @return void
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $user = User::query()->where('username', $this->username)->first();

            if (! $user || ! Hash::check($this->password, $user->password)) {
                $validator->errors()->add('username', 'Invalid username or password.');
            }
        });
    }
}
