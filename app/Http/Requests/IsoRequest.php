<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IsoRequest extends FormRequest
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
            "spec_no" => "required",
            "name" =>  "required",
            "document" =>  "required|mimes:pdf",
            "revision" =>  "required|min:2|max:10",
            "revision_date" =>  "required|date",
        ];
    }
}
