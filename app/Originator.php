<?php

namespace App;

use App\DCC\Traits\ModelInstance;
use Illuminate\Database\Eloquent\Model;

class Originator extends Model
{
    use ModelInstance;
    protected $fillable = [ 'department' ];

    protected $hidden = [
        'updated_at', 'created_at'
    ];

    public function companySpec()
    {
        return $this->belongsTo(\App\CompanySpec::class);
    }
}
