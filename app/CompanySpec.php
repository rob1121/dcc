<?php

namespace App;

use App\DCC\Traits\ModelInstance;
use Illuminate\Database\Eloquent\Model;

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
    public static function isExist($request)
    {
        $spec = collect(new self($request->all()))->toArray();
        return self::where($spec)->first();
    }
//
//    public function setSpecNoAttribute()
//    {
//        $count = explode("-", self::last()->spec_no);
//        $count[1]++;
//        $this->attributes['spec_no'] = implode("-", $count);
//    }
}
