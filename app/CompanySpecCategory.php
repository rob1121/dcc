<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanySpecCategory extends Model
{
    const RULES = [
        'category_no' => 'required|unique:company_spec_categories,category_no',
        'category_name' => 'required'
    ];

    protected $fillable = [ 'category_no', 'category_name' ];

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
