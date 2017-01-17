@extends("layouts.app")

@push("script")
<script src="{{URL::to("/js/log-index.js")}}"></script>
@endpush

@section("content")
    <div class="hidden-xs col-md-3 side">
        <div class="row">
            <input type="text" class="form-control input-lg" v-model="searchKey" placeholder="Look for...">
        </div>
    </div>

    <div class="col-xs-12 col-md-9 main-content">
        <ol class="breadcrumb">
            <li><a href="{{route("home")}}">Home</a></li>
            <li class="active">Log</li>
        </ol>

        <div class="clearfix"></div>

        <div class="row-fluid  hidden-md hidden-lg" style="margin-bottom: 5px">
            <input type="text" class="form-control input-lg" v-model="searchKey" placeholder="Look for...">
        </div>

        @include('errors.flash')
        <div class="clearfix row">
            @{{ date_from }}
            <div class="col-sm-3">
                <datepicker input-class="form-control input-sm"
                            v-model="date_from"
                            format="yyyy-MM-dd"
                            placeholder="Date from">
                </datepicker>
            </div>
            <div class="col-sm-3">
                <datepicker input-class="form-control input-sm"
                            v-model="date_to"
                            format="yyyy-MM-dd"
                            placeholder="Date to">
                </datepicker>
            </div>
            <button class="btn btn-default btn-sm" @click="fetchByDate">
                GO! <i class="fa fa-search"></i>
            </button>
        </div>
        <div class="panel panel-default">
            <table class="table table-hover">
                <th>IP</th>
                <th>User</th>
                <th>Details</th>
                <th>date time</th>
                <tbody v-if="documents.length">
                <tr v-for="spec in documents">
                    <td>@{{ spec.ip }}</td>
                    <td><strong>@{{spec.name | toUpper}}</strong></td>
                    <td>@{{ spec.description }}</td>
                    <td>@{{ spec.created_at}}</td>
                </tr>
                </tbody>
                <tfoot v-else>
                <tr>
                    <td colspan="2" class="text-center text-danger">No document specification found.</td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection