<?php

namespace App;

use App\DCC\Traits\ModelInstance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CompanySpec extends Model
{
    use ModelInstance;

    protected $fillable = ['name','spec_no'];

    protected $with = ['companySpecRevision', 'companySpecCategory'];

    public function companySpecRevision()
    {
        return $this->hasOne(CompanySpecRevision::class);
    }

    public function companySpecCategory()
    {
        return $this->hasOne(CompanySpecCategory::class);
    }

    /**
     * check if request instance already exist in the database
     * @param $request
     * @return mixed
     */
    public static function isExist(Request $request)
    {
        $spec = self::instance($request)->toArray();
        return self::where($spec)->first();
    }
}
