<?php namespace App;

use App\DCC\Traits\ModelInstance;
use Illuminate\Database\Eloquent\Model;

class CustomerSpecRevision extends Model
{
    use ModelInstance;
    protected $fillable = [
        'revision',
        'revision_date'
    ];

    protected $hidden = [
        'updated_at', 'created_at'
    ];

    public function customerSpec()
    {
        return $this->belongsTo(CustomerSpec::class);
    }
}
