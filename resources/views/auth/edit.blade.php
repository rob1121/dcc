
@extends('layouts.app')
@push('style')
<style>
    body {
        overflow-y: scroll;
    }
</style>
@endpush
@push('script')
<script src="{{URL::to("js/user-edit.js")}}"></script>
@endpush

@section('content')
    <div class="col-md-6 col-md-offset-3" style="margin-top: 10px">

        <ol class="breadcrumb">
            <li>
                <a href="{{route("home")}}">Home</a>
            </li>

            <li class="active">
                <a  href="{{route("user.index")}}">Users</a>
            </li>

            <li class="active">{{$user->employee_id . " - " . $user->name}}</li>
        </ol>

        @include('errors.flash')

        <div class="panel {{$errors->any() ? "panel-danger":"panel-default"}}">
            <div class="panel-heading">Register</div>
            <div class="panel-body">
                <form role="form" method="POST" action="{{route("user.update", ["user" => $user->id])}}">
                    {{ csrf_field() }}
                    {{ method_field("PATCH") }}
                    <input type="hidden" name="id" value="{{$user->id}}">

                    <div class="row">
                        <dcc-input name="name"
                                   value="{{sanitizeValue($user, "name", $errors)}}"
                                   error="{{$errors->first("name")}}"
                                   col="8">
                        </dcc-input>

                        <div class="col-sm-4 form-group{{ $errors->has('user_type') ? ' has-error' : '' }}">
                            <label for="user_type" class="control-label">User Type</label>
                            <select name="user_type" id="user_type" class="form-control input-sm" @change="togglePassword">
                                <option {{setSelectedUserType($user, "user_type","ADMIN")}}>ADMIN</option>
                                <option {{setSelectedUserType($user, "user_type","REVIEWER")}}>REVIEWER</option>
                                <option {{setSelectedUserType($user, "user_type","EMAIL RECEIVER ONLY")}}>EMAIL RECEIVER ONLY</option>
                            </select>

                            @if ($errors->has('user_type'))
                                <span class="help-block">
                                <strong>{{ $errors->first('user_type') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <dcc-input name="employee_id"
                                   value="{{sanitizeValue($user, "employee_id", $errors)}}"
                                   error="{{$errors->first("employee_id")}}"
                                   label="Employee No"
                                   col="4">
                        </dcc-input>

                        <dcc-input name="email"
                                   value="{{sanitizeValue($user, "email", $errors)}}"
                                   error="{{$errors->first("email")}}"
                                   col="8">
                        </dcc-input>
                    </div>

                    <div class="row" v-if="requirePassword">
                        <dcc-input name="password"
                                   type="password"
                                   error="{{$errors->first("password")}}"
                                   col="6">
                        </dcc-input>

                        <dcc-input name="password_confirmation"
                                   type="password"
                                   label="password confirmation"
                                   error="{{$errors->first("password_confirmation")}}"
                                   col="6">
                        </dcc-input>
                    </div>

                    <div class="row">
                        <div class="form-group {{ $errors->has('departments') ? ' has-error' : '' }}">
                            <label for="departments" class="col-sm-12 control-label">Department(s)
                                <departments name="departments"
                                             departments-list="{{App\Department::listDepartments()}}"
                                             value="{{sanitizeValue($user, "departments", $errors)}}">
                                </departments>
                            </label>
                            <h6 class="col-sm-12 help-block">
                                <strong>{{ $errors->first('departments') }}</strong>
                            </h6>
                        </div>

                        <div class="form-group">
                            <dcc-button btn-type="{{ $errors->any() ? "danger" : "primary" }}"
                                        icon="users"> Register User
                            </dcc-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
