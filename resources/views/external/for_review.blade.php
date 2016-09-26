@extends("layouts.app")

@push('style')
<link rel="stylesheet" href="{{URL::to("/css/external-for_review.css")}}">

@endpush


@push("script")
<script src="{{URL::to("/js/external-for_review.js")}}"></script>
@endpush

@section("content")
    <div id="sidebar">
        <a v-for="(index, category) in {{$categories}}"
           href="#"
           :class="['link', {'active': currentIndex == index }]"
        @click="getSpecByCategory(category, index)"
        >
        <h6>@{{category.customer_name}}</h6>
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
            <div class="clearfix"></div>
            <div class="deck" v-for="spec in pagination.data" v-if="pagination.data.length !== 0">
                <div class="spec-no col-xs-5"><h6>@{{spec.spec_no}} - @{{spec.name}}</h6></div>

                <div class="col-xs-2">
                    <a href="@{{spec.id | externalRoute}}" class="btn link" target="_blank">
                        <h6>@{{spec.customer_spec_revision | latestRevision "revision_date" | telfordStandardDate}}</h6>
                        <h6>@{{spec.customer_spec_revision | latestRevision "revision" | uppercase}}</h6>
                    </a>
                </div>
                <div class="col-xs-2">
                    <a class="btn btn-xs btn-warning" href="@{{spec.id | externalRoute}}/edit">Edit <i
                                class="fa fa-pencil"></i></a>
                    <button class="btn btn-xs btn-danger" data-toggle="modal" href="#spec-delete" @click="setModalSpec(spec)">
                        Remove <i class="fa fa-remove"></i>
                    </button>
                </div>
                <div class="dropdown col-xs-3">
                    <button class="btn btn-default btn-xs dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
                        List of Specifications for review
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                        <li role="presentation" v-for="for_review in spec.customer_spec_revision | orderBy 'revision'">
                            <a role="menuitem" href="#">
                                @{{for_review.revision | uppercase}} (@{{for_review.revision_date | telfordStandardDate}})
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div v-if="pagination.data.length === 0" class="container">
                <h1 class="text-danger">No document specification found.</h1>
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