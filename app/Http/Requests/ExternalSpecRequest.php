<?php

namespace App\Http\Requests;

use App\CustomerSpec;
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
        $spec = CustomerSpec::find(Request::input("id"));
        $id = $spec ? $spec->id : null;

        return [
            'name' => "required|unique:customer_specs,name,{$id}",
            'spec_no' => "required|unique:customer_specs,spec_no,{$id}",
            'revision' => "required|min:2|max:5",
            'document' => 'required|mimes:pdf',
            'revision_date' => "required|date",
            'customer_name' => 'required',
        ];
    }
}
