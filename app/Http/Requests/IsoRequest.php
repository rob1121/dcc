<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsoRequest extends FormRequest
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
            "spec_no" => "required|unique:isos,spec_no,". Request::input('id'),
            "name" =>  "required|unique:isos,name,". Request::input('id'),
            "document" =>  "required|mimes:pdf"
        ];
    }
}
