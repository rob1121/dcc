@extends('layouts.app')
@push("style")
<style>
    body {
        overflow: scroll
    }
</style>
@endpush

@push('script')
<script src="{{URL::to("/js/form.js")}}"></script>
@endpush

@section('content')
    <div class="col-md-6 col-md-offset-3" style="margin-top: 10px">

        <ol class="breadcrumb">
            <li>
                <a href="{{route("home")}}">Home</a>
            </li>
            <li><a href="{{route("esd.index")}}">Internal Specification</a></li>
            <li class="active"> New Internal Specification</li>
        </ol>

        @include('errors.flash')

        <div class="panel panel-{{$errors->any() ? "danger" : "default"}}">
            <div class="panel-heading">
                <h3 class="panel-title">Add new ESD document</h3>
            </div>
            <div class="panel-body">
                <form action="{{route('esd.store')}}" method="post" enctype="multipart/form-data" id="form-submit">
                    {{ csrf_field() }}
                    <div class="row">
                        <dcc-input name="spec_no"
                                   col="3"
                                   label="spec no."
                                   error="{{$errors->first("spec_no")}}"
                                   value="{{old("spec_no")}}"
                        ></dcc-input>

                        <dcc-input name="name"
                                   col="9"
                                   label="title"
                                   error="{{$errors->first("name")}}"
                                   value="{{old("name")}}"
                        ></dcc-input>
                    </div>

                    <div class="row">
                        <dcc-input name="document"
                                   col="6"
                                   type="file"
                                   error="{{$errors->first("document")}}"
                                   value="{{old("document")}}"
                        ></dcc-input>
                    </div>

                    <div class="col-md-12 row">
                        <button type="button"
                                class="btn pull-right btn-{{$errors->any() ? "danger" : "primary"}}"
                                data-toggle="modal"
                                href="#spec-submit"
                        >
                            Submit <i class="fa fa-paper-plane"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    @include('modal.confirmation')
@endsection