<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UsersUpdateRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required_without_all:last_name,email|string|max:50',
            'last_name'  => 'required_without_all:first_name,email|string|max:50',
            'email'      => 'required_without_all:first_name,last_name|email',
        ];
    }
}
