@extends("layouts.app")

@push("script")
<script src="{{URL::to("/js/external-index.js")}}"></script>
@endpush

@section("content")
    <div id="sidebar">
        <a v-for="(index, category) in {{$categories}}"
           href="#"
           :class="['btn-link', {'active': currentIndex == index }]"
        @click="getSpecByCategory(category, index)"
        >
        <h6 class="pull-right" style="margin-right: 10%">
            <strong>@{{category.customer_name}}</strong>
            <span class="label label-danger" v-if="category.customer_name | filterReduceMap">@{{ category.customer_name | filterReduceMap }}</span>
        </h6>

        </a>
    </div>

    <div class="loader">
        <dcc-pulse color="#2ab27b" size="50px"></dcc-pulse>
    </div>

    <div class="main-content">
        <button class="btn btn-default toggler-btn" @click="showSideBar">
        <i class="fa fa-bars"></i>
        <span>Toggle sidebar</span>
        </button>
        <br>
        <div class="deck-collection">

            <ol class="breadcrumb">
                <li><a href="{{route("home")}}">Home</a></li>
                <li class="active">Internal Specification</li>
                <li class="active">@{{ category.customer_name | uppercase }}</li>
            </ol>

            @if(Auth::user() && Auth::user()->is_admin)
                <a href="{{route("external.create")}}" class="pull-right btn btn-primary" style="margin-bottom: 10px">
                    Add new external specification <i class="fa fa-plus"></i>
                </a>
            @endif
            <div class="clearfix"></div>

            @include('errors.flash')

            <div class="deck" v-for="spec in pagination.data" v-if="pagination.data.length !== 0">
                <div class="spec-no col-sm-12
                    @if(Auth::user() && Auth::user()->is_admin)         col-md-7
                    @elseif(Auth::user()&& ! Auth::user()->is_admin)    col-md-8
                    @else col-md-12
                    @endif
                justify">

                    <a class="show-action-link" href="@{{spec.id | externalRoute}}" target="_blank" style="word-wrap: break-word">
                        <h4>@{{spec.spec_no | uppercase}} - @{{spec.name | uppercase}} </h4>
                    </a>
                    <h6>
                        <strong>Revision: </strong>
                        <span class="label label-info">@{{spec.customer_spec_revision | latestRevision 'revision' | uppercase}}</span>
                        <strong>Date: </strong>
                        <span class="label label-info">@{{spec.customer_spec_revision | latestRevision 'revision_date' | telfordStandardDate}}</span>
                    </h6>
                </div>
                @if(Auth::user())
                    <div class="col-sm-12
                        @if(Auth::user() && Auth::user()->is_admin)         col-md-5
                        @elseif(Auth::user()&& ! Auth::user()->is_admin)    col-md-4
                        @endif
                    ">
                        @if(Auth::user()->is_admin)
                            <a id="update-btn" class="btn btn-xs btn-default" href="@{{spec.id | routeEditLink }}">
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
                                v-if="spec.customer_spec_revision | filterBy 0 in 'is_reviewed' | count"
                        >
                            <span class="badge">@{{ spec.customer_spec_revision | filterBy 0 in 'is_reviewed' | count }}</span>
                            pending for review <i class="fa fa-file-o"></i>
                        </a>
                    </div>
                @endif
            </div>
            <div v-if="pagination.data.length === 0" class="container">
                <h1 class="text-danger">No document specification found.</h1>
            </div>
        </div>

        <div class="pagination-link">
            <div class="pagination-nav">
                <ul class="pagination pull-right" v-if="pagination.total > 1">
                    <!-- Previous Page Link -->
                    <li class="disabled" v-if="pagination.current_page === 1"><span><i
                                    class="fa fa-arrow-left"></i></span></li>
                    <li v-else><a href="#" @click.prevent="prev" rel="prev"><i class="fa fa-arrow-left"></i></a></li>

                    <!-- Next Page Link -->
                    <li v-if="pagination.current_page !== pagination.last_page">
                        <a href="#" @click.prevent="next" rel="next"><i class="fa fa-arrow-right"></i></a>
                    </li>
                    <li class="disabled" v-else><span><i class="fa fa-arrow-right"></i></span></li>
                </ul>
            </div>
            <div class="pagination-text pull-right">
                <h6><span>Displaying @{{ pagination.from }} to @{{ pagination.to }} of @{{ pagination.total }}</span>
                </h6>
            </div>
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
                        @{{ modalConfirmation.category.spec_no | uppercase }} - @{{ modalConfirmation.category.name | uppercase }}
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
            <div v-for="specRevision in modalConfirmation.category.customer_spec_revision | filterBy 0 in 'is_reviewed'">
                <div class="col-xs-{{Auth::user()->is_admin ? 8 : 9 }} col-xs-offset-1">

                    <a v-if="modalConfirmation.category" href="@{{ specRevision | documentLink }}" target="_blank">
                        <h4>@{{ modalConfirmation.category.spec_no | uppercase}} @{{ modalConfirmation.category.name | uppercase}}</h4>
                    </a>

                    <span class="help-block">
                        <strong>Revision: </strong>@{{ specRevision.revision | uppercase}}
                        <strong>Date: </strong>@{{ specRevision.revision_date | telfordStandardDate}}
                    </span>
                </div>

                @if(Auth::user()->is_admin)
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
                v-if="modalConfirmation.category.customer_spec_revision | isHasForReview">
                No pending external specification for review.
            </h1>
        <div class="clearfix"></div>
    </dcc-modal>
@endsection