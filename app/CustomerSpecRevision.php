<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerSpecRevision extends Model
{
    protected $fillable = [
        'revision',
        'revision_date'
    ];

    public function customerSpec()
    {
        return $this->belongsTo(CustomerSpec::class);
    }
}
