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
        'spec_no', 'name', 'document', 'revision', 'revision_date'
    ];

    protected $appends = [
        'title', 'iso_show', 'iso_edit'
    ];

    /**
     * @param Request $request
     * @return Iso
     */
    public static function instance(Request $request)
    {
        return (new self($request->all()));
    }

    public static function isExist(Request $request)
    {
        $instance = self::instance($request)->toArray();
        return self::where($instance)->first();
    }
}
