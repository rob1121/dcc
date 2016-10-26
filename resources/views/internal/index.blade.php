@extends("layouts.app")

@push("script") <script src="{{URL::to("/js/internal-index.js")}}"></script> @endpush

@section("content")
    <div class="deck-collection">
        <ol class="breadcrumb">
            <li>
                <a href="{{route("home")}}">Home</a>
            </li>
            <li class="active">Internal Specification</li>
            <li class="active">@{{category.category_title | toUpper}}</li>
        </ol>
        @if(Auth::user() && isAdmin())
            <a href="{{route("internal.create")}}" class="pull-right btn btn-primary" style="margin-bottom: 10px">
                Add new internal specification <i class="fa fa-plus"></i>
            </a>
        @endif
        <div class="clearfix"></div>

        @include('errors.flash')
        <div class="panel panel-default">
            <table class="table table-hover">
                <tbody v-if="pagination.length">
                <tr v-for="spec in pagination">
                    <td>
                        <a :href="spec.internal_show">
                            <span class="label label-success" v-if="spec.highlight">@{{ spec.highlight }}</span>
                            <strong>@{{spec.spec_name | toUpper}}</strong>
                        </a>
                        <br>
                        <small>@{{spec.revision_summary | capitalize}}</small>
                    </td>
                    <td>
                        <strong>Revision: </strong>@{{spec.company_spec_revision.revision | toUpper}}
                        <strong>Date: </strong>@{{spec.company_spec_revision.revision_date | telfordStandardDate}}
                        <br>
                        @if(Auth::user() && isAdmin())
                            <a id="update-btn" class="btn btn-xs btn-default" :href="spec.internal_edit">
                                Update <i class="fa fa-edit"></i>
                            </a>
                            <button id="delete-btn" class="btn btn-xs btn-danger" data-toggle="modal" href="#spec-delete" @click="
                        setModalSpec(spec)">Remove <i class="fa fa-remove"></i>
                            </button>
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
               id="spec-delete"
               class-type="danger"
    >
        <h3 class="text-center">
            Are you sure you want to permanently <strong class="text-danger">delete</strong>
            <br>
            "<strong class="text-danger">
                @{{modalConfirmation.category.spec_name | toUpper}}
            </strong>"?
        </h3>

        <div class="text-center">
            <button type="button" class="btn btn-danger" data-dismiss="modal" @click="removeSpec">Yes</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
        </div>
    </dcc-modal>
@endsection