<?php

namespace App;

use App\DCC\Traits\ModelInstance;
use App\Dcc\Traits\Presenter\InternalSpecCategoryPresenter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CompanySpecCategory extends Model
{
    use ModelInstance,InternalSpecCategoryPresenter;

    protected $fillable = [
        'category_no', 'category_name'
    ];

    protected $appends = [
        'category_title'
    ];

    protected $hidden = [
        'updated_at', 'created_at'
    ];

    public static function generateSpecNo(Request $request)
    {
        $category = is_a($request->category,'add_category')
            ? CompanySpecCategory::whereCategoryNo($request->category_no)->get()
            : CompanySpecCategory::whereCategoryNo($request->category)->get();

        $spec_no = 0;
        $hasCategory = $category->count();

        if($hasCategory) {
            $spec_no = $category->map(function($spec) {
                return   $spec->companySpec;
            })->sortByDesc('spec_no')->first()->spec_no;
        }

        return $spec_no + 1;
    }

    public function companySpec(){
        return $this->belongsTo(CompanySpec::class);
    }

    public static function categoryList() {
        return self::with("companySpec")->get(["category_name","category_no","company_spec_id"]);
    }

    public static function getCategoryList() {
        return collect( self::orderBy("category_no")->get(["category_name","category_no"])->unique("category_no") )
            ->map( function($category) {
                return collect($category)->put("name", "{$category->category_title}");
            } );
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

    public function setCategoryNameAttribute($value)
    {
        $this->attributes['category_name'] = trim($value);
    }

    public function setCategoryNoAttribute($value)
    {
        $this->attributes['category_no'] = trim($value);
    }
}
