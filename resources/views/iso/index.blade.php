@extends("layouts.app")

@push("script")
<script src="{{URL::to("/js/iso-index.js")}}"></script>
@endpush

@section("content")
<div class="deck-collection">

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

    <div class="deck" v-for="iso in pagination" v-if="pagination">
        <div class="spec-no col-sm-12
            @if(Auth::user() && isAdmin()) col-md-9
            @else col-md-12
            @endif
                justify">

            <a class="show-action-link" :href="showRouteFor(iso.id)" target="_blank" style="word-wrap: break-word">
                <h4>@{{uppercase(iso.spec_no)}} - @{{uppercase(iso.name)}} </h4>
            </a>
            <h6 class="help-block">
                <strong>Revision:   </strong> @{{uppercase(iso.revision)}}
                <strong>Date:       </strong> @{{telfordStandardDate(iso.revision_date)}}
            </h6>
        </div>
        @if(Auth::user())
            <div class="col-sm-12
                            @if(Auth::user() && isAdmin()) col-md-3 @endif
                        ">

                @if(isAdmin())
                    <a id="update-btn" class="btn btn-xs btn-default" :href="editRouteFor(iso.id)">
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
            </div>
        @endif
    </div>
    <div v-if="! pagination" class="container">
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
                @{{uppercase(selectedIso.spec_no)}} - @{{uppercase(selectedIso.name)}}
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