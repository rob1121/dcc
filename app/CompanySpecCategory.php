<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanySpecCategory extends Model
{

    protected $fillable = [ 'category_no', 'category_name' ];

    public static function getCategoryList()
    {
        return collect(self::orderBy('category_no')->get())->unique('category_no');
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
