@extends("layouts.app")

@push("script")
<script src="{{URL::to("/js/esd-index.js")}}"></script>
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
            <li class="active">ESD Document</li>
        </ol>

        @if(Auth::user() && isAdmin())
            <a href="{{route("esd.create")}}" class="pull-right btn btn-primary" style="margin-bottom: 10px">
                Add new ESD document<i class="fa fa-plus"></i>
            </a>
        @endif

        <div class="clearfix"></div>


        <div class="row-fluid  hidden-md hidden-lg" style="margin-bottom: 5px">
            <input type="text" class="form-control input-lg" v-model="searchKey" placeholder="Look for...">
        </div>

        @include('errors.flash')
        <div class="panel panel-default">
            <table class="table table-hover">
                <th>ESD document</th>
                <tbody v-if="documents.length">
                <tr v-for="spec in documents">
                    <td>
                        <a :href="spec.esd_show"  target="_blank">
                            <strong>@{{spec.spec_no + " " + spec.name | toUpper}}</strong>
                        </a>
                    </td>
                    <td class="col-sm-2">
                        @if(isAdmin())
                            <a id="update-btn" class="btn btn-xs btn-default" :href="spec.esd_edit">
                                Update <i class="fa fa-edit"></i>
                            </a>

                            <a id="delete-btn" class="btn btn-xs btn-danger"
                               data-toggle="modal"
                               href="#spec-confirm"
                            @click="setModalSpec(spec)"
                            >
                            Remove <i class="fa fa-remove"></i>
                            </a>
                        @endif
                    </td>
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
    {{--=======================================MODALS=================================--}}
    <dcc-modal title="Modal confirmation"
               id="spec-confirm"
               class-type="danger"
               scroll="off"
    >
        <div class="text-center" v-if="selected">
            <h4>
                Are you sure you want to permanently <strong class="text-danger">delete</strong>
                "<strong class="text-danger">
                    @{{selected.title}}
                </strong>"?
            </h4>
            <button type="button"
                    class="btn btn-danger"
                    data-dismiss="modal"
            @click="removeESD"
            >Yes
            </button>
            <button type="button"
                    class="btn btn-default"
                    data-dismiss="modal"
            >No
            </button>
        </div>
    </dcc-modal>
@endsection