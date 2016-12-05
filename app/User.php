<?php

namespace App;

use App\DCC\Traits\ModelInstance;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use ModelInstance;
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'employee_id', 'user_type', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function department()
    {
        return $this->hasMany(Department::class);
    }

    /**
     * return user with department equals to originator department
     *
     * @param array $originator_departments
     * @return mixed
     */
    public static function  departmentIsIn(array $originator_departments)
    {
        return self::with([
            "department" => function($query) use($originator_departments) {
                $query->whereIn('department', $originator_departments);
            }
        ])
        ->get()
        ->filter(function($user) {
            return collect($user->department)->count();
        });
    }

    public static function getReviewer($reviewer)
    {
        return self::with([
        "department" => function($query) use ($reviewer) {
            $query->whereDepartment($reviewer);
        }])
        ->whereUserType("REVIEWER")
        ->orWhere("user_type","ADMIN")
        ->get()
        ->filter(function($user) {
            return collect($user->department)->count();
        });
    }

    public function scopeGetCategoryList()
    {
        return $this->get(['user_type'])->unique(['user_type'])->pluck(['user_type']);
    }

    public function originator()
    {
        return $this->hasMany(\App\Originator::class);
    }

    public static function isExist(Request $request)
    {
        $instance = self::instance($request)->toArray();
        return self::where($instance)->first();
    }

    public static function allUser()
    {
        self::initializeMacro();
        $users = self::where('id','<>', Auth::user()->id)->get()->userTransformer();

        return self::putHTMLVerbLinks($users);
    }

    public static function employeeIdHighestCharCount()
    {
        $id = self::orderBy("employee_id", "desc")->first()->employee_id;
        return strlen($id);
    }

    public static function departmentList()
    {
        return self::get(['department'])->unique("department")->map(function($department) {
            return $department->department;
        })->toArray();
    }

    private static function initializeMacro() {

        Collection::macro('userTransformer', function() {

            $charCount = User::employeeIdHighestCharCount();

            return collect($this->items)->map(function($user) use($charCount) {
                $user->employee_id = sprintf("%0{$charCount}d", $user->employee_id);
                return $user;
            });
        });
    }

    private static function putHTMLVerbLinks($users)
    {
        return $users->map(function ($item) {
            return collect($item)
                ->put("delete_route", route("user.destroy", ["user" => $item->id]))
                ->put("edit_route", route("user.edit", ["user" => $item->id]));
        })->toArray();
    }
    
    public function setEmployeeIdAttribute($value)
    {
        $this->attributes['employee_id'] = trim($value);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = trim($value);
    }

}
