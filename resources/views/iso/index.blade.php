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

    @if(Auth::user() && Auth::user()->is_admin)
        <a href="{{route("iso.create")}}" class="pull-right btn btn-primary" style="margin-bottom: 10px">
            Add new ISO document<i class="fa fa-plus"></i>
        </a>
    @endif

    <div class="clearfix"></div>

    @include('errors.flash')

    <div class="deck" v-for="iso in isos" v-if="isos">
        <div class="spec-no col-sm-12
            @if(Auth::user() && Auth::user()->is_admin) col-md-9
            @else col-md-12
            @endif
                justify">

            <a class="show-action-link" href="@{{iso.id | isoRoute}}" target="_blank" style="word-wrap: break-word">
                <h4>@{{iso.spec_no | uppercase}} - @{{iso.name | uppercase}} </h4>
            </a>
            <h6 class="help-block">
                <strong>Revision:   </strong> @{{iso.revision | uppercase}}
                <strong>Date:       </strong> @{{iso.revision_date | telfordStandardDate}}
            </h6>
        </div>
        @if(Auth::user())
            <div class="col-sm-12
                            @if(Auth::user() && Auth::user()->is_admin) col-md-3 @endif
                        ">

                @if(Auth::user()->is_admin)
                    <a id="update-btn" class="btn btn-xs btn-default" href="@{{iso.id | routeEditLink }}">
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
    <div v-if="! isos" class="container">
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
                @{{ selectedIso.spec_no | uppercase }} - @{{ selectedIso.name | uppercase }}
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