@extends('layouts.app')

@push("script")
  <script src="{{URL::to("/js/create.js")}}"></script>
@endpush

@section('content')
    <div class="col-xs-10">

        <ol class="breadcrumb">
            <li>
                <a href="{{route("home")}}">Home</a>
            </li>
            <li><a href="{{route("iso.index")}}">Internal Specification</a></li>
            <li class="active"> New Internal Specification</li>
        </ol>

          @include('errors.flash')

        <div class="panel panel-{{$errors->any() ? "danger" : "default"}}">
            <div class="panel-heading">
                <h3 class="panel-title">Add new ISO document</h3>
            </div>
            <div class="panel-body">
                <form action="{{route('iso.store')}}" method="post" enctype="multipart/form-data" id="form-submit">
                    {{ csrf_field() }}

                    <dcc-input name="spec_no"
                               col="3"
                               label="spec no."
                               error="{{$errors->has("spec_no") ? $errors->first("spec_no"):""}}"
                               value="{{old("spec_no")}}"
                    ></dcc-input>

                    <dcc-input name="name"
                               col="9"
                               label="title"
                               error="{{$errors->has("name") ? $errors->first("name"):""}}"
                               value="{{old("name")}}"
                    ></dcc-input>

                    <dcc-input name="revision"
                               col="3"
                               error="{{$errors->has("revision") ? $errors->first("revision"):""}}"
                               value="{{old("revision")}}"
                    ></dcc-input>

                    <dcc-datepicker name="revision_date"
                                    col="3"
                                    label="date"
                                    error="{{$errors->has("revision_date") ? $errors->first("revision_date"):""}}"
                                    value="{{old("revision_date")}}"
                    ></dcc-datepicker>

                    <dcc-input name="document"
                               col="3"
                               type="file"
                               error="{{$errors->has("document") ? $errors->first("document"):""}}"
                               value="{{old("document")}}"
                    ></dcc-input>
                    <div class="col-md-12">
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