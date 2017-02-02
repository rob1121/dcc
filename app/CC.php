<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CC extends Model
{
    protected $table="ccs";

    protected $fillable=[
        'email'
    ];

    protected $hidden=[
        "created_at", "updated_at"
    ];

    public static function findQuery($q) {
        return self::where('email','LIKE',"%{$q}%")->select(['email'])->get()->unique('email')->values();
    }

    public function customerSpec(){
        return $this->belongsTo(CustomerSpec::class);
    }

    public function companySpec(){
        return $this->belongsTo(CompanySpec::class);
    }

    public function setEmailAttribute($value){
        $this->attributes['email'] = trim($value);
    }
}
