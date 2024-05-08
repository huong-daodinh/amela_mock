<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class CreateUserRequest extends FormRequest
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
            'email' => 'bail|required|string|email',
            'password' => 'bail|required|string|min:9|confirmed',
            // 'password_confirm' => 'bail|same:password',
            'name' => 'bail|required|string',
            'avatar' => [
                'nullable',
                File::image()->min('1kb')->max('5mb')
            ],
            'date_of_birth' => 'required',
            'gender' => 'required',
            'department' => 'required'
        ];
    }
}
