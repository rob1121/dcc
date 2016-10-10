<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class InternalSpecRequest extends FormRequest
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
        $id = Request::input("id");
        return [
            "name"              => "required|unique:company_specs,name,{$id}",
            "spec_no"           => "required|unique:company_specs,spec_no,{$id}",
            "revision"          => "required|min:2|max:5",
            "revision_summary"  => "required",
            "document"          => "required|mimes:pdf",
            "revision_date"     => "required|date",
            "category_no"       => "required",
            "category_name"     => "required"
        ];
    }
}
