<?php

namespace App;

use App\DCC\Traits\ModelInstance;
use Illuminate\Database\Eloquent\Model;

class Originator extends Model
{
    use ModelInstance;
    protected $fillable = [ 'department', 'user_id' ];

    protected $with = [
        'users'
    ];

    public function companySpec()
    {
        return $this->belongsToMany(\App\CompanySpec::class);
    }

    public function users()
    {
        return $this->belongsToMany(\App\User::class);
    }
}
