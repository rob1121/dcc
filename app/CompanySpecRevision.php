<?php

namespace App;

use App\DCC\Traits\ModelInstance;
use Illuminate\Database\Eloquent\Model;

class CompanySpecRevision extends Model
{
    use ModelInstance;

    protected $fillable = [
        'revision',
        'revision_summary',
        'revision_date'
    ];

    public static function countOfNewRevision() {
        return self::where("revision_date",">", \Carbon::now()->subDays(7))->get()
            ->map(function($item) { return $item->companySpec->companySpecCategory; });
    }

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
