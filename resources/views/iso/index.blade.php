@extends("layouts.app")

@push("script")
<script src="{{URL::to("/js/iso-index.js")}}"></script>
@endpush

@section("content")
<div class="form">

    <ol class="breadcrumb">
        <li><a href="{{route("home")}}">Home</a></li>
        <li class="active">ISO Document</li>
    </ol>

    @if(Auth::user() && isAdmin())
        <a href="{{route("iso.create")}}" class="pull-right btn btn-primary" style="margin-bottom: 10px">
            Add new ISO document<i class="fa fa-plus"></i>
        </a>
    @endif

    <div class="clearfix"></div>

    @include('errors.flash')
    <div class="row">
        <div class="col-md-5">
            <div class="input-group">
                <input type="text" v-model="searchKey" placeholder="Look for...">
            </div>
        </div>
        <br><br>
    </div>
    <div class="panel panel-default">
        <table class="table table-hover">
            <tbody v-if="documents.length">
            <tr v-for="spec in documents">
                <td>
                    <a :href="spec.iso_show">
                        <strong>@{{spec.name | toUpper}}</strong>
                    </a>
                    <br>
                    <strong>Revision: </strong>@{{spec.revision}}
                    <strong>Date: </strong>@{{spec.revision_date}}
                </td>
                <td>
                        @if(isAdmin())
                            <a id="update-btn" class="btn btn-xs btn-default" :href="spec.iso_edit">
                                Update <i class="fa fa-edit"></i>
                            </a>

                            <a id="delete-btn" class="btn btn-xs btn-danger"
                               data-toggle="modal"
                               href="#spec-confirm"
                            @click="setModalSpec(iso)"
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
    <div v-if="! documents" class="container">
        <h1 class="text-danger">No document specification found.</h1>
    </div>
</div>
{{--=======================================MODALS=================================--}}
<dcc-modal title="Modal confirmation"
           id="spec-confirm"
           class-type="danger"
           scroll="off"
>
    <div class="text-center" v-if="selectedIso">
        <h4>
            Are you sure you want to permanently <strong class="text-danger">delete</strong>
            "<strong class="text-danger">
                @{{selectedIso.title}}
            </strong>"?
        </h4>
        <button type="button"
                class="btn btn-danger"
                data-dismiss="modal"
        @click="removeIso"
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