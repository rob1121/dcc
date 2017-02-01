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
        $requireCategory = Request::input("category") == "add_category";
        return [
            "name"              => "required|unique:company_specs,name,". $id ."|max:100",
            "revision"          => "required|min:2|max:5",
            "revision_summary"  => "max:500",
            "document"          => "required|mimes:pdf",
            "revision_date"     => "required|date",
            "category_no"       => $requireCategory ? "required": "",
            "category_name"       => $requireCategory ? "required": "",
//            "cc"          => json_decode(Request::input("send_notification")) ? "required" : ""
        ];
    }
}
