<?php

namespace App;

use App\DCC\Traits\ModelInstance;
use Illuminate\Database\Eloquent\Model;

class CompanySpecCategory extends Model
{
    use ModelInstance;

    protected $fillable = [ 'category_no', 'category_name' ];

    public function companySpec(){
        return $this->belongsTo(CompanySpec::class);
    }
    public static function categoryList() {
        return self::with("companySpec")->get(["category_name","category_no","company_spec_id"]);
    }

    public static function getCategoryList() {
        return self::get(["category_name","category_no","company_spec_id"])->unique("category_no")->sortBy("category_no");
    }

    /**
     * get company_spec_categories if data is exist
     * @param $category_no
     * @return mixed
     */
    public static function isUnique($category_no)
    {
        return self::whereCategoryId($category_no)->count();
    }
}
