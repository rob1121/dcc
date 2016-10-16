@extends('layouts.app')

@push('script')
    <script src="{{url("/js/user-index.js")}}"></script>
@endpush

@section('content')
<div class="form">
    <div class="row-fluid">
        <a href="{{url('/register')}}" class="btn btn-primary pull-right">Add new user <i class="fa fa-plus"></i></a>
    </div>
    @include("errors.flash")
    <table class="table ">
        <thead>
            <th class="text-right">#</th>
            <th>Name</th>
            <th>Category</th>
            <th>Department</th>
            <th>Email</th>
            <th class="text-right">Action</th>
        </thead>
        <tbody>
            <tr v-for="user in pagination.data">
                <td class="text-right">@{{ user.employee_id }}</td>
                <td>@{{ user.name | nameCase }}</td>
                <td>@{{ user.user_type | capitalize }}</td>
                <td>@{{ user.department | capitalize }}</td>
                <td>@{{ user.email }}</td>
                <td class="text-right">
                    <a :href="editRouteFor(user.id)" class="btn btn-default btn-xs">edit <i class="fa fa-edit"></i></a>
                    <button @click="deleteUser(user)" class="btn btn-danger btn-xs">delete <i class="fa fa-remove"></i></button>
                </td>
            </tr>
        </tbody>
    </table>
    @include("search.result", ["show" => true])
</div>
@endsection
