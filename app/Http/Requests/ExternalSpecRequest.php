<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'name' => 'required',
            'spec_no' => 'required',
            'revision' => "required|min:2|max:5",
            'document' => 'required|mimes:pdf',
            'revision_date' => "required|date",
            'customer_name' => 'required',
        ];
    }
}
