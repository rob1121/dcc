<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanySpecRevision extends Model
{
    const RULES = [
        'revision' => "required|max:5",
        'revision_summary' => "required",
        'document' => 'required|mimes:pdf',
        'revision_date' => "required|date"
    ];

    protected $fillable = [
        'revision',
        'revision_summary',
        'revision_date'
    ];
}
