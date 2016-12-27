<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return "ADMIN" === Auth::user()->user_type;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "user_type" => "required",
            "departments" => "required",
            "name" => "required",
            "employee_id" => ["required", "max:20", Rule::unique("users")->ignore(Request::input("id"))],
            "email" => ["required", Rule::unique("users")->ignore(Request::input("id"))],
            'password'    => ! Request::input("password") ? '' : 'required|min:6|confirmed',

        ];
    }
}
