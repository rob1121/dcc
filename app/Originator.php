<?php

namespace App;

use App\DCC\Traits\ModelInstance;
use Illuminate\Database\Eloquent\Model;

class Originator extends Model
{
    use ModelInstance;
    protected $fillable = [ 'department' ];

    public function companySpec()
    {
        return $this->belongsTo(\App\CompanySpec::class);
    }
}
