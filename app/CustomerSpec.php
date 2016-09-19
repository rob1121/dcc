<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerSpec extends Model
{
    protected $fillable = [ 'spec_no', 'name' ];

    protected $with = ['customerSpecRevision', 'customerSpecCategory'];

    public function customerSpecRevision()
    {
        return $this->hasMany(CustomerSpecRevision::class);
    }

    public function customerSpecCategory()
    {
        return $this->hasOne(CustomerSpecCategory::class);
    }
}
