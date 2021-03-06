
@extends('layouts.app')
@push('style')
<style>
    body {
        overflow-y: scroll;
    }
</style>
@endpush
@push('script')
    <script src="{{URL::to("js/user-registration.js")}}"></script>
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

            <li class="active">{{ "Add new user" }}</li>
        </ol>

        @include('errors.flash')

        <div class="panel {{$errors->any() ? "panel-danger":"panel-default"}}">
            <div class="panel-heading">Register</div>
            <div class="panel-body">
                <form role="form" method="POST" action="{{url('/register')}}">
                    {{ csrf_field() }}

                    <div class="row">
                        <dcc-input name="name"
                                   value="{{old("name")}}"
                                   error="{{$errors->first("name")}}"
                                   col="8">
                        </dcc-input>

                        <div class="col-sm-4 form-group{{ $errors->has('user_type') ? ' has-error' : '' }}">
                            <label for="user_type" class="control-label">User Type</label>
                            <select name="user_type" id="user_type" class="form-control input-sm" @change="togglePassword">
                                <option {{selectUserType("user_type","ADMIN")}}>ADMIN</option>
                                <option {{selectUserType("user_type","REVIEWER")}}>REVIEWER</option>
                                <option {{selectUserType("user_type","EMAIL RECEIVER ONLY")}}>EMAIL RECEIVER ONLY</option>
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
                                   value="{{old("employee_id")}}"
                                   error="{{$errors->first("employee_id")}}"
                                   label="Employee No"
                                   col="4">
                        </dcc-input>

                        <dcc-input name="email"
                                   value="{{old("email")}}"
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
                                             value="{{json_encode(old("departments"))}}">
                                </departments>
                            </label>
                            <h6 class="col-sm-12 help-block">
                                <strong>{{ $errors->first('departments') }}</strong>
                            </h6>
                        </div>


                        <div class="col-md-12 form-group">
                            <label>
                                <input type="checkbox" name="copy_on_cc">
                                Copy on cc
                            </label>
                        </div>

                        <div class="form-group">
                            <dcc-button btn-type="{{ $errors->any() ? "danger" : "primary" }}"
                                        icon="save"> Update User
                            </dcc-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
