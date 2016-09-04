<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanySpecRevision extends Model
{
    const RULES = [
        'revision' => "required|max:5",
        'revision_summary' => "required",
        'revision_date' => "required|date"
    ];

    protected $fillable = [
        'revision',
        'company_spec_id',
        'revision_summary',
        'revision_date'
    ];
}
