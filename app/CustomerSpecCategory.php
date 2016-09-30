<?php

namespace App;

use App\DCC\Traits\ModelInstance;
use Illuminate\Database\Eloquent\Model;

class CustomerSpecCategory extends Model
{

    use ModelInstance;
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
