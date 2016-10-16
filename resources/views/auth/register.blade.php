@extends('layouts.app')

@push('script')
<script src="{{URL::to("js/form.js")}}"></script>
<script>
    function togglePassword(userType) {
        var password = $(".password");
        if( userType === "EMAIL RECEIVER ONLY" ) password.hide()
        else password.show();
    }

    togglePassword($("#user_type").val());

    $("#user_type").on("change", function() {
        togglePassword($(this).val());
    });
</script>
@endpush

@section('content')
@include('errors.flash')
<div class="panel {{$errors->any() ? "panel-danger":"panel-default"}} form">
    <div class="panel-heading">Register</div>
    <div class="panel-body">
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('user_type') ? ' has-error' : '' }}">
                <label for="user_type" class="col-xs-4 control-label">User Type</label>

                <div class="col-xs-6">
                    <select name="user_type" id="user_type" class="form-control">
                        <option disabled selected> -- Select One -- </option>
                        <option @if(old("user_type") === "ADMIN" || ( isset($user) && $user->user_type === "ADMIN" )) selected @endif>ADMIN</option>
                        <option @if(old("user_type") === "REVIEWER" || ( isset($user) && $user->user_type === "REVIEWER" )) selected @endif>REVIEWER</option>
                        <option @if(old("user_type") === "EMAIL RECEIVER ONLY" || ( isset($user) && $user->user_type === "EMAIL RECEIVER ONLY" )) selected @endif>EMAIL RECEIVER ONLY</option>
                    </select>

                    @if ($errors->has('user_type'))
                        <span class="help-block">
                            <strong>{{ $errors->first('user_type') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('department') ? ' has-error' : '' }}">
                <label for="department" class="col-xs-4 control-label">Department</label>

                <div class="col-xs-6">
                    <select name="department" id="department" class="form-control">
                        <option value="" disabled selected> -- Select One -- </option>
                        <option value="QA"  @if(old("department") === "QA" || ( isset($user) && $user->department === "QA" )) selected @endif>QA</option>
                        <option value="PE"  @if(old("department") === "PE" || ( isset($user) && $user->department === "PE" )) selected @endif>PE</option>
                    </select>

                    @if ($errors->has('department'))
                        <span class="help-block">
                            <strong>{{ $errors->first('department') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('employee_id') ? ' has-error' : '' }}">
                <label for="employee_id" class="col-xs-4 control-label">Employee ID</label>

                <div class="col-xs-6">
                    <input id="employee_id"
                           type="text"
                           class="form-control"
                           name="employee_id"
                           value="@if(old('employee_id')) {{old('employee_id')}} @elseif(isset($user)) {{$user->employee_id}} @endif"
                    >

                    @if ($errors->has('employee_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('employee_id') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="col-xs-4 control-label">Name</label>

                <div class="col-xs-6">
                    <input id="name"
                           type="text"
                           class="form-control"
                           name="name"
                           value="@if(old("name")) {{old('name')}}  @elseif(isset($user)) {{$user->name}} @endif"

                    >

                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="col-xs-4 control-label">E-Mail Address</label>

                <div class="col-xs-6">
                    <input id="email"
                           type="email"
                           class="form-control"
                           name="email"
                           value="@If(old('email')) {{old('email')}} @elseif(isset($user)) {{$user->email}} @endif"
                    >

                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="password form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password" class="col-xs-4 control-label">Password</label>

                <div class="col-xs-6">
                    <input id="password" type="password" class="form-control" name="password">

                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="password form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                <label for="password-confirm" class="col-xs-4 control-label">Confirm Password</label>

                <div class="col-xs-6">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation">

                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class="col-xs-6 col-xs-offset-4">
                    <button type="submit" class="btn btn-{{ $errors->any() ? "danger" : "primary" }} pull-right">
                        Register User <i class="fa fa-users"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
