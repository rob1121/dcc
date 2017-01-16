<?php namespace App;

use App\DCC\Traits\ModelInstance;
use App\Dcc\Traits\Presenter\ESDPresenter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ESD extends Model
{
    use ModelInstance, ESDPresenter;

    protected $table = 'esd';

    protected $fillable = [
        'spec_no', 'name', 'document'
    ];

    protected $appends = [
        'title', 'esd_show', 'esd_edit'
    ];

    protected $hidden = [
        'updated_at', 'created_at'
    ];

    /**
     * @param array $collection
     * @return ESD
     */
    public static function instance(array $collection){
        return (new self($collection))->getAttributes();
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = trim($value);
    }

    public function setSpecNoAttribute($value)
    {
        $this->attributes['spec_no'] = trim($value);
    }

    public static function isExist(array $collection)
    {
        $instance = self::instance($collection);
        return self::where($instance)->first();
    }
}
