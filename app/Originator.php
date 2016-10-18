<?php

namespace App;

use App\DCC\Traits\ModelInstance;
use Illuminate\Database\Eloquent\Model;

class Originator extends Model
{
    use ModelInstance;
    protected $fillable = [ 'department', 'user_id' ];

    protected $with = [
        'user', 'companySpec'
    ];

    public function companySpec()
    {
        return $this->belongsTo(\App\CompanySpec::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }
}
