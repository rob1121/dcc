<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanySpec extends Model
{

    const RULES = [
        'name' => 'required'
    ];

    protected $fillable = ['name','spec_no'];

    public static function isExist($request)
    {
        $spec = collect(new self($request->all()))->toArray();
        return self::where($spec)->first();
    }

    public function companySpecRevision()
    {
        return $this->hasMany(CompanySpecRevision::class);
    }

    public function companySpecCategory()
    {
        return $this->hasOne(CompanySpecCategory::class);
    }
//
//    public function setSpecNoAttribute()
//    {
//        $count = explode("-", self::last()->spec_no);
//        $count[1]++;
//        $this->attributes['spec_no'] = implode("-", $count);
//    }
}
