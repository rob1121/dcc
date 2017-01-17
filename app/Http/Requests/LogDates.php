<?php

namespace App\Http\Requests;

use App\DCC\Logs\DateFormatter;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class LogDates extends FormRequest
{
    private $logDate;

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
        $this->logDate = new DateFormatter();
        return [
            "date_from"  => "required|date|" . Request::input('date_to') ? "before:{$this->logDate->to(Request::input('date_to'))}" : "",
            "date_to"    => "required|date|" . Request::input('date_from') ? "after:{$this->logDate->from(Request::input('date_from'))}" : "",
        ];
    }
}
