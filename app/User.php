<?php

namespace App;

use App\DCC\Traits\ModelInstance;
use App\Dcc\Traits\Presenter\UserPresenter;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use ModelInstance, Notifiable, UserPresenter;

    protected $fillable = [
        'name', 'email', 'employee_id', 'user_type', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token', 'created_at', 'updated_at'
    ];

//    protected $appends = [
//        'edit_route', 'delete_route'
//    ];

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

    /**
     * get collection of email to be followup for the external specs to be reviewed
     * @param array $reviewer
     * @return mixed
     */
    public static function followUp(array $reviewer)
    {
        return Department::whereIn('department', $reviewer)
            ->with(['user' => function($query) {
                $query->select(['id','email']);
            }])->get()
            ->unique('user.email')
            ->pluck('user.email');
    }

    /**
     * get reviewer of external specs
     * @param $reviewer
     * @return mixed
     */
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

    public static function findQuery($lookItem=null, $count = 5)
    {
            return static::with('department')->where("name","like","%{$lookItem}%")
                ->orWhere("employee_id","like","%{$lookItem}%")
                ->orWhere("email","like","%{$lookItem}%")
                ->take($count)
                ->get(['id', 'name', 'email']);
    }

    public static function findQueryInDepartment($lookItem=null, $count = 5)
    {
        return static::with([ 'department' => function($query) use($lookItem) {
            return $query->where('department','like',"%{$lookItem}%");
        } ])->get(['id', 'name', 'email'])
            ->groupBy('department.*.department')
            ->take($count);
    }
}
