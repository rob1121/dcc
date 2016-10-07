@extends("layouts.app")

@push("script") <script src="{{URL::to("/js/internal-index.js")}}"></script> @endpush

@section("content")
    <div class="deck-collection">
        <ol class="breadcrumb">
            <li>
                <a href="{{route("home")}}">Home</a>
            </li>
            <li class="active">Internal Specification</li>
            <li class="active">@{{uppercase(category.category_no)}}
                - @{{uppercase(category.category_name)}}</li>
        </ol>
        @if(Auth::user() && Auth::user()->is_admin)
            <a href="{{route("internal.create")}}" class="pull-right btn btn-primary" style="margin-bottom: 10px">
                Add new internal specification <i class="fa fa-plus"></i>
            </a>
        @endif
        <div class="clearfix"></div>

        @include('errors.flash')

        <div class="deck" v-for="spec in pagination.data" v-if="pagination.data">
            <div class="spec-no col-xs-12 col-md-9">
                <a class="show-action-link" target="_blank" :href="internalRouteFor(spec.id)">
                    <h4>
                        @{{uppercase(spec.spec_no)}} - @{{uppercase(spec.name)}}
                        <span class="label label-success"
                              v-if="isNewRevision(spec.company_spec_revision.revision_date)"
                        >
                            new revision
                        </span>
                    </h4>

                </a>
                <h5 class="help-block">@{{capitalize(spec.company_spec_revision.revision_summary)}}</h5>
            </div>
            <div class="col-xs-12 col-md-3">
                <h6>
                    <strong>Revision: </strong>@{{uppercase(spec.company_spec_revision.revision)}}
                    <strong>Date: </strong>@{{telfordStandardDate(spec.company_spec_revision.revision_date)}}
                </h6>
                @if(Auth::user() && Auth::user()->is_admin)
                    <a id="update-btn" class="btn btn-xs btn-default" :href="internalEditRouteFor(spec.id)">
                        Update <i class="fa fa-edit"></i>
                    </a>
                    <button id="delete-btn" class="btn btn-xs btn-danger" data-toggle="modal" href="#spec-delete" @click="
                    setModalSpec(spec)">Remove <i class="fa fa-remove"></i>
                    </button>
                @endif
            </div>
        </div>
        <div v-if="! pagination.data" class="container">
            <h1 class="text-danger">No document specification found.</h1>
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
                @{{uppercase(modalConfirmation.category.spec_no)}} - @{{uppercase(modalConfirmation.category.name)}}
            </strong>"?
        </h3>

        <div class="text-center">
            <button type="button" class="btn btn-danger" data-dismiss="modal" @click="removeSpec">Yes</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
        </div>
    </dcc-modal>
@endsection