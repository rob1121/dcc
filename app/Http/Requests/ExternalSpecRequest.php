<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ExternalSpecRequest extends FormRequest
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
        $rules_for_spec_revision_update = [
            'name' => "required",
            'spec_no' => "required",
            'revision' => "required|min:2|max:5",
            'document' => 'required|mimes:pdf',
            'revision_date' => "required|date",
            'reviewer' => "required",
            'customer_name' => 'required',
        ];
        $rules_for_spec_status_update = [
            "is_reviewed" => "required|boolean",
            'revision' => "required|min:2|max:5",
        ];
        return Request::input("is_reviewed") ? $rules_for_spec_status_update : $rules_for_spec_revision_update;
    }
}
