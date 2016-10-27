<?php

namespace App;

use App\DCC\Traits\ModelInstance;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use ModelInstance;
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'employee_id', 'department', 'user_type', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * return user with department equals to originator department
     *
     * @param array $originator_departments
     * @return mixed
     */
    public static function departmentIsIn(array $originator_departments)
    {
        return self::whereIn("department", $originator_departments)->get();
    }

    public static function getReviewer($reviewer)
    {
        return self::whereUserType("REVIEWER")->whereDepartment($reviewer)
            ->orWhere("user_type","ADMIN")->get();
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
        $users = self::all()->userTransformer();

        $usersMap = $users->map(function($item) {
            $route_links = collect($item)->put("delete_route", route("user.destroy", ["user" => $item->id ]) )
                ->put("edit_route", route("user.edit", ["user" => $item->id ]) );

            return $route_links;
        })->toArray();

        return $usersMap;
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
}
