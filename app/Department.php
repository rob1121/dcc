<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        "department"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public static function list()
    {
        return static::get(['department'])->unique('department')->pluck('department')->toJson();
    }
}
