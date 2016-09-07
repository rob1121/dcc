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

    public function companySpec()
    {
        return $this->belongsTo(CompanySpec::class);
    }

    public static function isExist($company_spec_id,$revision)
    {
        return self::whereCompanySpecId($company_spec_id)->whereRevision($revision)->first();
    }

    public function setRevisionSummaryAttribute($value)
    {
        return $this->attributes['revision_summary'] = trim($value);
    }
}
