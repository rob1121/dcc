<?php

namespace App;

use App\DCC\Traits\ModelInstance;
use Illuminate\Database\Eloquent\Model;

class CustomerSpecRevision extends Model
{
    use ModelInstance;
    protected $fillable = [
        'revision',
        'revision_date',
        'reviewer'
    ];

    public static function uniqueReviewer() {
        return self::get(["reviewer"])->unique("reviewer")->pluck("reviewer");
    }

    public function customerSpec()
    {
        return $this->belongsTo(CustomerSpec::class);
    }
}
