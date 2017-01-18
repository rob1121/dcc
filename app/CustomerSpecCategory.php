<?php

namespace App;

use App\DCC\Traits\ModelInstance;
use Illuminate\Database\Eloquent\Model;

class CustomerSpecCategory extends Model
{

    use ModelInstance;
    protected $fillable = ["customer_name"];

    protected $hidden = [
        'updated_at', 'created_at'
    ];

    public static function customerList() {
        return self::get(["customer_name"])->unique("customer_name")->flatten();
    }

    public function customerSpec() {
        return $this->belongsTo(CustomerSpec::class);
    }

    public static function getCategoryList() {
        return self::orderBy("customer_name")->get(["customer_name"])->unique("customer_name")
            ->map(function($category) {
                $category_name = \Str::upper($category->customer_name);
                return collect($category)
                        ->put("category_no", $category->customer_name)
                        ->put("name", $category_name);
            });
    }
}
