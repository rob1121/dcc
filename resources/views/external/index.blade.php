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
            <span class="badge">@{{ category.count }}</span>
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
            <a href="{{route("external.create")}}" class="pull-right btn btn-primary" style="margin-bottom: 10px">Add
                new external specification <i class="fa fa-plus"></i>
            </a>
            <div class="clearfix"></div>
            <div class="deck" v-for="spec in pagination.data" v-if="pagination.data.length !== 0">
                <div class="spec-no col-sm-12 col-md-8 justify">
                    <a href="@{{spec.id | externalRoute}}" target="_blank" style="word-wrap: break-word">
                        <h4>@{{spec.spec_no | uppercase}} - @{{spec.name | uppercase}}</h4>
                    </a>
                    <h6 class="help-block">
                        <strong>Revision: </strong>@{{spec.customer_spec_revision | latestRevision 'revision' | uppercase}}
                        <strong>Date: </strong>@{{spec.customer_spec_revision | latestRevision 'revision_date' | telfordStandardDate}}
                    </h6>
                </div>
                <div class="col-sm-12 col-md-4">
                    <a class="btn btn-xs btn-default" href="@{{spec.id | externalRoute}}/edit">
                        Update <i class="fa fa-pencil"></i>
                    </a>

                    <button class="btn btn-xs btn-warning"
                            data-toggle="modal"
                            href="#spec-delete"
                            @click=" setModalSpec(spec)"
                    >
                    Remove <i class="fa fa-remove"></i>
                    </button>

                    <button class="btn btn-xs btn-danger"
                            data-toggle="modal"
                            href="#spec-for-review"
                            title="Click here to view specification for review"
                            @click="setSpecForReviewModal(spec)"
                            v-if="spec.customer_spec_revision | filterBy 0 in 'is_reviewed' | count"
                    >
                    @{{ spec.customer_spec_revision | filterBy 0 in 'is_reviewed' | count }} pending for review <i class="fa fa-file-o"></i>
                    </button>
                </div>
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
    <dcc-modal title="Modal confirmation" id="spec-delete" class-type="danger" size="sm">
        <div class="text-center">
            <h4>Are you sure you want to delete?</h4>
            <button type="button" class="btn btn-danger" data-dismiss="modal" @click="removeSpec">Yes</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
        </div>
    </dcc-modal>

    <dcc-modal title="External specification for review" id="spec-for-review" class-type="info" size="lg">
        <div v-for="specRevision in specForReviewModal.customer_spec_revision | filterBy 0 in 'is_reviewed'">
            <div class="col-xs-7 col-xs-offset-2">

                <a v-if="specForReviewModal" href="@{{ specRevision | documentLink }}" target="_blank">
                    <h4>@{{ specForReviewModal.spec_no | uppercase}} @{{ specForReviewModal.name | uppercase}}</h4>
                </a>

                <span class="help-block">
                    <strong>Revision: </strong>@{{ specRevision.revision | uppercase}}
                    <strong>Date: </strong>@{{ specRevision.revision_date | telfordStandardDate}}
                </span>
            </div>

            <div class="col-xs-1">
                <button type="button" class="btn btn-xs btn-success" data-dismiss="modal" @click="removeSpec">
                    Done Review <i class="fa fa-check"></i>
                </button>
            </div>
        </div>
        <div class="clearfix"></div>
    </dcc-modal>
@endsection