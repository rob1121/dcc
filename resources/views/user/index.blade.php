@extends('layouts.app')

@push('script')
    <script src="{{url("/js/user-index.js")}}"></script>
@endpush

@section('content')
    <div class="hidden-xs col-md-3 side">
        <div class="row">
            <input type="text" class="form-control input-lg" v-model="searchKey" placeholder="Look for...">
            <hr>
        </div>

        <div class="row">
            <ul class="list-group">
                <li :class="['list-group-item', searchCategoryKey === category.category_no ? 'active' : '']"
                    v-for="category in {{$categories}}"
                @click="setActiveCategory(category.category_no)"
                >
                @{{ category.name }}
                </li>
            </ul>
        </div>
    </div>

    <div class="col-xs-12 col-md-9 main-content">

        <ol class="breadcrumb">
            <li>
                <a href="{{route("home")}}">Home</a>
            </li>
            <li class="active">Users</li>
        </ol>

        <div class="row-fluid">
            <div class="clearfix">
                <a href="{{url('/register')}}" class="btn btn-primary pull-right">Add new user <i class="fa fa-plus"></i></a>
            </div>
            <br>
        </div>

        @include("errors.flash")

        <div class="row-fluid  hidden-md hidden-lg" style="margin-bottom: 5px">
            <input type="text" class="form-control input-lg" v-model="searchKey" placeholder="Look for...">
        </div>

        <div class="panel panel-default">

            <div class="table-responsive">

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
                        <td><li v-for="department in user.departments">@{{ department | toUpper}}</li></td>
                        <td>@{{ user.email }}</td>
                        <td class="text-right"  style="white-space: nowrap;">
                            <a :href="user.edit_route" class="btn btn-default btn-xs">edit <i class="fa fa-edit"></i></a>
                            <button class="btn btn-danger btn-xs" data-toggle="modal" href="#spec-delete" @click="
                            setModalUser(user)">delete <i class="fa fa-remove"></i></button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

</div>

    {{--=======================================MODALS=================================--}}
    <dcc-modal title="Modal confirmation"
               id="spec-delete"
               class-type="danger"
    >
        <h3 class="text-center">
            Are you sure you want to permanently <strong class="text-danger">delete</strong>
            <br>
            "<strong class="text-danger">
                @{{modalConfirmation.category.name | toUpper}}
            </strong>"?
        </h3>

        <div class="text-center">
            <button type="button" class="btn btn-danger" data-dismiss="modal" @click="removeUser">Yes</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
        </div>
    </dcc-modal>
@endsection
