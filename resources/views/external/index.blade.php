@extends("layouts.app")

@push('style')
    <link rel="stylesheet" href="{{url("/css/internal-index.css")}}">
@endpush


@push("script")
    <script src="{{url("/js/internal-index.js")}}"></script>
@endpush

@section("content")
    <div id="sidebar">
        <a v-for="(index, category) in {{$categories}}"
           href="#"
           :class="['link', {'active': currentIndex == index }]"
        @click="getSpecByCategory(category, index)"
        >
        <h6>@{{category.category_no}} - @{{category.category_name}}</h6>
        </a>
    </div>

    <div class="main-content">
        <div class="loader">
            <dcc-pulse color="#2ab27b" size="50px"></dcc-pulse>
        </div>
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


            <a href="{{route("internal.create")}}" class="pull-right btn btn-primary" style="margin-bottom: 10px">Add
                new Specs <i class="fa fa-plus"></i></a>
            <div class="clearfix"></div>
            <div class="deck" v-for="spec in pagination.data" v-if="pagination.data.length !== 0">
                <div class="spec-no col-xs-3"><h6>@{{spec.spec_no}} - @{{spec.name}}</h6></div>
                <div class="col-xs-4"><h6>@{{spec.company_spec_revision.revision_summary | trim}}</h6></div>
                <div class="col-xs-2">
                    <h6>@{{spec.company_spec_revision.revision_date | telfordStandardDate}}</h6>
                    <h6>@{{spec.company_spec_revision.revision | uppercase}}</h6>
                </div>
                <div class="col-xs-3">
                    <a class="btn btn-xs btn-primary" target="_blank" href="/internal/@{{spec.id}}"> View <i
                                class="fa fa-file-pdf-o"></i></a>
                    <a class="btn btn-xs btn-warning" href="/internal/@{{spec.id}}/edit">Edit <i
                                class="fa fa-pencil"></i></a>
                    <button class="btn btn-xs btn-danger" data-toggle="modal" href="#spec-delete" @click="
                    setModalSpec(spec)">Remove <i
                            class="fa fa-remove"></i></button>
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
    <dcc-modal title="Modal confirmation" id="spec-delete">
        <h1>Are you sure you want to delete?</h1>
        <div class="text-center">
            <button type="button" class="btn btn-danger" data-dismiss="modal" @click="removeSpec">Yes</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
        </div>
    </dcc-modal>
@endsection