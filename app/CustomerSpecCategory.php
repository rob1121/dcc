<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerSpecCategory extends Model
{
    protected $fillable = ["customer_name"];

    public function customerSpec() {
        return $this->belongsTo(CustomerSpec::class);
    }

    public static function getCategoryList() {
        return collect(self::orderBy('customer_name')->get())->unique('customer_name');
    }
}
