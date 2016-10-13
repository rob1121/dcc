@extends("layouts.app")

@push("script")
<script src="{{URL::to("/js/external-index.js")}}"></script>
@endpush

@section("content")
    <div class="deck-collection">

        <ol class="breadcrumb">
            <li><a href="{{route("home")}}">Home</a></li>
            <li class="active">Internal Specification</li>
            <li class="active">@{{ uppercase(category.customer_name) }}</li>
        </ol>

        @if(Auth::user() && isAdmin())
            <a href="{{route("external.create")}}" class="pull-right btn btn-primary" style="margin-bottom: 10px">
                Add new external specification <i class="fa fa-plus"></i>
            </a>
        @endif
        <div class="clearfix"></div>

        @include('errors.flash')
        <div class="col-md-12"v-if="pagination.data">
            <select name="status_filter" id="status_filter" v-model="status_filter">
                <option value="all">All</option>
                <option value="for review">For Review</option>
            </select>
        </div>
        <div class="deck" v-for="spec in externalSpecs" v-if="pagination.data">
            <div class="spec-no col-sm-12
                @if(Auth::user() && isAdmin())         col-md-7
                @elseif(Auth::user()&& ! isAdmin())    col-md-8
                @else col-md-12
                @endif
            justify">

                <a class="show-action-link" :href="externalRouteFor(spec.customer_spec_revision)" target="_blank" style="word-wrap: break-word">
                    <h4>@{{uppercase(spec.spec_no)}} - @{{uppercase(spec.name)}} </h4>
                </a>
                <h6>
                    <strong>Revision: </strong>
                    <span class="label label-info">@{{uppercase( getLatestRevision(spec.customer_spec_revision, 'revision') )}}</span>
                    <strong>Date: </strong>
                    <span class="label label-info">@{{telfordStandardDate( getLatestRevision( spec.customer_spec_revision, "revision_date" ) )}}</span>
                </h6>
            </div>
            @if(Auth::user())
                <div class="col-sm-12
                    @if(Auth::user() && isAdmin())         col-md-5
                    @elseif(Auth::user()&& ! isAdmin())    col-md-4
                    @endif
                ">
                    @if(isAdmin())
                        <a id="update-btn" class="btn btn-xs btn-default" :href="externalEditRouteFor(spec.id)">
                            Update <i class="fa fa-edit"></i>
                        </a>

                        <a id="delete-btn" class="btn btn-xs btn-danger"
                                data-toggle="modal"
                                href="#spec-confirm"
                                @click=" setModalSpec(spec,'delete')"
                        >
                        Remove <i class="fa fa-remove"></i>
                        </a>
                    @endif
                    <a id="for-review-btn" class="btn btn-xs btn-success"
                            data-toggle="modal"
                            href="#spec-for-review"
                            title="Click here to view specification for review"
                            @click="setModalSpec(spec,'update')"
                            v-if="getCustomerSpecsForReview(spec.customer_spec_revision ).length"
                    >
                        <span class="badge">@{{getCustomerSpecsForReview( spec.customer_spec_revision ).length}}</span>
                        pending for review <i class="fa fa-file-o"></i>
                    </a>
                </div>
            @endif
        </div>
        <div v-if="! pagination.data" class="container">
            <h1 class="text-danger">No document specification found.</h1>
        </div>
    </div>

    {{--=======================================MODALS=================================--}}
    <dcc-modal title="Modal confirmation"
               id="spec-confirm"
               :class-type="modalConfirmation.action === 'update' ? 'success' : 'danger'"
               scroll="off"
    >
        <div class="text-center">
            <div v-if="modalConfirmation.action === 'update'">
                <h3>Mark <strong>@{{ modalConfirmation.category.name }}</strong> as <strong class="text-success">complete</strong></h3>
                <h4>Click <strong>Yes</strong> to confirm action.</h4>
            </div>
            <div v-else>
                <h4>
                    Are you sure you want to permanently <strong class="text-danger">delete</strong>
                    "<strong class="text-danger">
                        @{{ uppercase(modalConfirmation.category.spec_no)}} - @{{ uppercase(modalConfirmation.category.name)}}
                    </strong>"?
            </h4>
            </div>
            <div v-if="modalConfirmation.action === 'delete'">
                <button type="button"
                        :class="modalConfirmation.action === 'update' ? 'btn btn-success' : 'btn btn-danger'"
                        data-dismiss="modal"
                @click="modalAction"
                >Yes
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            </div>
            <div v-else>
                <button type="button"
                        :class="modalConfirmation.action === 'update' ? 'btn btn-success' : 'btn btn-danger'"
                        data-dismiss="modal" data-toggle="modal" href="#spec-for-review"
                @click="modalAction"
                >Yes
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal" data-toggle="modal" href="#spec-for-review">No</button>
            </div>
        </div>
    </dcc-modal>

    <dcc-modal title="External specification for review"
               id="spec-for-review"
               class-type="info"
               size="lg"
               scroll="on"
    >
            <div v-for="specRevision in customerSpecForReview">
                <div class="col-xs-{{isAdmin() ? 8 : 9 }} col-xs-offset-1">

                    <a v-if="modalConfirmation.category" :href="externalRouteFor(specRevision)" target="_blank">
                        <h4>@{{ uppercase(modalConfirmation.category.spec_no)}} @{{ uppercase(modalConfirmation.category.name)}}</h4>
                    </a>

                    <span class="help-block">
                        <strong>Revision: </strong>@{{ uppercase(specRevision.revision)}}
                        <strong>Date: </strong>@{{telfordStandardDate(specRevision.revision_date)}}
                    </span>
                </div>

                @if(isAdmin())
                    <div class="col-xs-1">
                        <button type="button"
                                class="btn btn-xs btn-default"
                                data-dismiss="modal"
                                data-toggle="modal"
                                href="#spec-confirm"
                                @click="setUpdateSpec(specRevision)"
                        >
                            Done Review <i class="fa fa-check"></i>
                        </button>
                    </div>
                @endif
            </div>
        <div class="clearfix"></div>
            <h1 class="text-center text-success"
                v-if="customerSpecForReview.length < 1">
                No pending external specification for review.
            </h1>
        <div class="clearfix"></div>
    </dcc-modal>
@endsection