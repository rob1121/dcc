<?php

namespace App;

use App\DCC\Traits\ModelInstance;
use App\Dcc\Traits\Presenter\IsoPresenter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Iso extends Model
{
    use ModelInstance, IsoPresenter;

    protected $fillable = [
        'spec_no', 'name', 'document'
    ];

    protected $appends = [
        'title', 'iso_show', 'iso_edit'
    ];

    protected $hidden = [
        'updated_at', 'created_at'
    ];

    /**
     * @param Request $request
     * @return Iso
     */
    public static function instance(Request $request)
    {
        return (new self($request->all()));
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = trim($value);
    }

    public function setSpecNoAttribute($value)
    {
        $this->attributes['spec_no'] = trim($value);
    }

    public static function isExist(Request $request)
    {
        $instance = self::instance($request)->getAttributes();
        return self::where($instance)->first();
    }
}
