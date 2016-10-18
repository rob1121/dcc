<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InternalSpecRequest extends FormRequest
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
        $id = Request::input("id");
        return [
            "name"              => "required|unique:company_specs,name,{$id}|max:100",
            "spec_no"           => "required|unique:company_specs,spec_no,{$id}|max:100",
            "revision"          => "required|min:2|max:5",
            "revision_summary"  => "required|max:500",
            "document"          => "required|mimes:pdf",
            "revision_date"     => "required|date",
            "category_no"       => "required|max:100",
            "category_name"     => "required|max:100",
            "department"     => "required"
        ];
    }
}
