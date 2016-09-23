<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerSpecCategory extends Model
{
    protected $fillable = ["customer_name"];

    public static function customerList() {
        return self::get(["customer_name"])->unique("customer_name")->flatten();
    }

    public function customerSpec() {
        return $this->belongsTo(CustomerSpec::class);
    }

    public static function getCategoryList() {
        return collect(self::orderBy('customer_name')->get())->unique('customer_name');
    }
}
