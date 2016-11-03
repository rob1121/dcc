@extends('layouts.app')

@push('style')
    <style>
        #app #sidebar { display: none; }

         #app .content { width: 100vw; }
    </style>
@endpush

@push('script')
    <script src="{{url("/js/user-index.js")}}"></script>
@endpush

@section('content')
<div v-if="users" class="container-fluid" >

    <ol class="breadcrumb">
        <li>
            <a href="{{route("home")}}">Home</a>
        </li>
        <li class="active">Users</li>
    </ol>

    <div class="row-fluid">
            <a href="{{url('/register')}}" class="btn btn-primary pull-right">Add new user <i class="fa fa-plus"></i></a>
        <div class="clearfix"></div>
        <br>
    </div>
    @include("errors.flash")
    <div class="table-responsive">
        <input type="text" v-model="searchKey" placeholder="Look for...">

        <table class="table">
            <thead>
                <th @click="sortColumn('employee_id')" class="text-right">#</th>
                <th @click="sortColumn('name')">Name</th>
                <th @click="sortColumn('user_type')">Category</th>
                <th @click="sortColumn('department')">Department</th>
                <th @click="sortColumn('email')">Email</th>
                <th class="text-right">Action</th>
            </thead>
            <tbody>
            <tr v-for="user in users">
                <td class="text-right">@{{ user.employee_id}}</td>
                <td style="white-space: nowrap;">@{{ user.name | nameCase }}</td>
                <td  style="white-space: nowrap;">@{{ user.user_type | toUpper }}</td>
                <td>@{{ user.department | toUpper }}</td>
                <td>@{{ user.email }}</td>
                <td class="text-right"  style="white-space: nowrap;">
                    <a :href="user.edit_route" class="btn btn-default btn-xs">edit <i class="fa fa-edit"></i></a>
                    <button @click="remove(user)" class="btn btn-danger btn-xs">delete <i class="fa fa-remove"></i></button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
