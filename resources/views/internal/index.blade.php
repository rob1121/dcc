
@extends("layouts.app")

@push("script")
<script src="{{URL::to("/js/internal-index.js")}}"></script>
@endpush

@section("content")
    <div id="sidebar">
        <a v-for="(index, category) in {{$categories}}"
           href="#"
           :class="['btn-link', {'active': currentIndex == index }]"
        @click="getSpecByCategory(category, index)"
        >
        <h6><strong>@{{category.category_no}} - @{{category.category_name}}</strong></h6>
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
                <li>
                    <a href="{{route("home")}}">Home</a>
                </li>
                <li class="active">Internal Specification</li>
                <li class="active">@{{ category.category_no | uppercase }}
                    - @{{ category.category_name | uppercase }}</li>
            </ol>
            @if(Auth::user() && Auth::user()->is_admin)
                <a href="{{route("internal.create")}}" class="pull-right btn btn-primary" style="margin-bottom: 10px">
                    Add new internal specification <i class="fa fa-plus"></i>
                </a>
            @endif
            <div class="clearfix"></div>
            <div class="deck" v-for="spec in pagination.data" v-if="pagination.data.length !== 0">
                <div class="spec-no col-xs-12 col-md-9">
                    <a target="_blank" href="@{{spec.id | internalRoute}}">
                        <h4>@{{spec.spec_no | uppercase}} - @{{spec.name | uppercase}}</h4>
                    </a>
                    <h5 class="help-block">@{{spec.company_spec_revision.revision_summary  | capitalize}}</h5>
                </div>
                <div class="col-xs-12 col-md-3">
                    <h6>
                        <strong>Revision: </strong>@{{spec.company_spec_revision.revision | uppercase}}
                        <strong>Date: </strong>@{{spec.company_spec_revision.revision_date | telfordStandardDate}}
                    </h6>
                    @if(Auth::user() && Auth::user()->is_admin)
                        <a id="update-btn" class="btn btn-xs btn-default" href="@{{spec.id | internalRoute}}/edit">
                            Update <i class="fa fa-edit"></i>
                        </a>
                        <button id="delete-btn" class="btn btn-xs btn-danger" data-toggle="modal" href="#spec-delete" @click="
                        setModalSpec(spec)">Remove <i class="fa fa-remove"></i>
                        </button>
                    @endif
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
    <dcc-modal title="Modal confirmation"
               id="spec-delete"
               class-type="danger"
    >
        <h3 class="text-center">
            Are you sure you want to permanently <strong class="text-danger">delete</strong>
            <br>
            "<strong class="text-danger">
                @{{ modalDeleteConfirmation.category.spec_no | uppercase}} - @{{ modalDeleteConfirmation.category.name | uppercase}}
            </strong>"?
        </h3>

        <div class="text-center">
            <button type="button" class="btn btn-danger" data-dismiss="modal" @click="removeSpec">Yes</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
        </div>
    </dcc-modal>
@endsection