<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerSpecCategory extends Model
{
    protected $fillabe = ["customer_name"];

    public function customerSpec()
    {
        return $this->belongsTo(CustomerSpec::class);
    }
}
