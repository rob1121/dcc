<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        "department"
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public static function listDepartments()
    {
        return static::get(['department'])->unique('department')->pluck('department')->toJson();
    }

    public function scopeSearchInput($query, $lookItem)
    {
        return $query->with(['user' => function($query) use($lookItem) {
            $query->findQuery($lookItem);
        }])->get()
            ->groupBy('user.name')
            ->toArray();
    }

    public function scopeFindDepartments($query, $lookItem)
    {
        return $query->where('department', 'like', "%{$lookItem}%")
            ->with('user')
            ->get()
            ->unique('user.email')
            ->groupBy('department')
            ->toArray();
    }
}
