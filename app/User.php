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

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'employee_id', 'department', 'user_type', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function isExist(Request $request)
    {
        $instance = self::instance($request)->toArray();
        return self::where($instance)->first();
    }

    public static function allUser()
    {
        $charCount = self::employeeIdHighestCharCount();

        $users = self::paginate(15)->toArray();

        $users["data"] = collect($users["data"])->map(function($item) use($charCount) {
            $item["employee_id"] = sprintf("%0{$charCount}d", $item["employee_id"]);
            $item = collect($item)->put("delete_route", route("user.destroy", ["user" => $item["id"] ]) );
            return $item;
        });

        return $users;
    }

    public static function employeeIdHighestCharCount()
    {
        $id = self::orderBy("employee_id", "desc")->first()->employee_id;
        return strlen($id);
    }
}
