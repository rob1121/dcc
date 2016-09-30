<?php

namespace App;

use App\DCC\Traits\ModelInstance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Iso extends Model
{
    use ModelInstance;

    protected $fillable = [ 'spec_no', 'name', 'document', 'revision', 'revision_date' ];

    /**
     * @param Request $request
     * @return Iso
     */
    public static function instance(Request $request)
    {
        return (new self($request->all()));
    }
}
