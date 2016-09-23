<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanySpecCategory extends Model
{

    protected $fillable = [ 'category_no', 'category_name' ];

    public static function getCategoryList()
    {
        return self::get(["category_name","category_no"])->unique("category_no")->flatten();
    }

    public function companySpec()
    {
        return $this->belongsTo(CompanySpec::class);
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
