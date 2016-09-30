<?php

namespace App;

use App\DCC\Traits\ModelInstance;
use Illuminate\Database\Eloquent\Model;

class CustomerSpec extends Model {

    use ModelInstance;
    protected $fillable = [ 'spec_no', 'name' ];

    protected $with = ['customerSpecRevision', 'customerSpecCategory'];

    public function customerSpecRevision() {
        return $this->hasMany(CustomerSpecRevision::class);
    }

    public function customerSpecCategory() {
        return $this->hasOne(CustomerSpecCategory::class);
    }

    /**
     * check if request instance already exist in the database
     * @param $request
     * @return mixed
     */
    public static function isExist($request) {
        $spec = collect(new self($request->all()))->toArray();
        return self::where($spec)->first();
    }
}
