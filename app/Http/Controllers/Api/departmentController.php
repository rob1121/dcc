<?php

namespace App\Http\Controllers\Api;

use App\Department;
use App\Http\Controllers\Controller;

class departmentController extends Controller
{
    public function departments()
    {
        return response()->json(Department::list());
    }
}
