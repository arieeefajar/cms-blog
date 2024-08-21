<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAuthorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'fullname' => 'required|string|max:50',
            'username' => 'required|string|max:6',
            'email' => 'required|email',
            'status' => 'required|in:active,inactive',
        ];
    }

    public function messages()
    {
        return [
            'fullname.required' => 'Fullname harus diisi',
            'fullname.string' => 'Fullname harus berupa string',
            'fullname.max' => 'Fullname maksimal 50 karakter',

            'username.required' => 'Username harus diisi',
            'username.string' => 'Username harus berupa string',
            'username.max' => 'Username maksimal 6 karakter',

            'email.required' => 'Email harus diisi',
            'email.email' => 'Email harus valid',

            'status.required' => 'Status harus diisi',
            'status.in.active' => 'Status harus active',
            'status.in.inactive' => 'Status harus inactive',
        ];
    }
}
