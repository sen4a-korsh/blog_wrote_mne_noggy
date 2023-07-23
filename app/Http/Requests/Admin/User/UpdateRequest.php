<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
            'name' => 'required|string',
//            'user_id' => 'required|integer|exists:users,id',
            'email' => ['required','string','email', Rule::unique('users')->ignore($this->user)],
//            'password' => 'nullable|string',
            'role_id' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            '*.required' => 'Fill in the fields',
            '*.string' => 'Value must be string',
            'email.email' => 'Incorrect mail',
            'email.unique' => 'This mail is already taken',
            'role_id.integer' => 'Value must be integer',
        ];
    }
}
