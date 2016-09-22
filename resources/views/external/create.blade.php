@extends('layouts.app')

@push("style")
    <link rel="stylesheet" href="{{url("/css/external-create.css")}}">
@endpush

@push("script")
    <script src="{{url("/js/external-create.js")}}"></script>
@endpush

@section('content')
    <div class="container">

        <ol class="breadcrumb">
            <li>
                <a href="{{route("home")}}">Home</a>
            </li>
          <li><a href="{{route("external.index")}}">External Specification</a></li>
          <li class="active"> New External Specification</li>
        </ol>

        <div class="panel panel-{{$errors->any() ? "danger" : "default"}}">
            <div class="panel-heading">
              <h3 class="panel-title">Add new External Specification</h3>
            </div>
            <div class="panel-body">
                <form action="{{route('external.store')}}" method="post" enctype="multipart/form-data" id="form-submit">
                    {{ csrf_field() }}
                    <div class="container-fluid">
                        <dcc-input name="customer_name"
                                   col="4"
                                   label="customer name"
                                   list="browsers"
                                   error="{{$errors->has("customer_name") ? $errors->first("customer_name"):""}}"
                                   value="{{old("customer_name")}}"
                        ></dcc-input>

                        <datalist id="browsers">
                            <option v-for="category in {{$categories}}" value="@{{ category.customer_name }}">
                        </datalist>

                        <dcc-input name="revision"
                                   col="4"
                                   error="{{$errors->has("revision") ? $errors->first("revision"):""}}"
                                   value="{{old("revision")}}"
                        ></dcc-input>

                        <dcc-datepicker name="revision_date"
                                        col="4"
                                        label="date"
                                        error="{{$errors->has("revision_date") ? $errors->first("revision_date"):""}}"
                                        value="{{old("revision_date")}}"
                        ></dcc-datepicker>
                    </div>

                    <div class="container-fluid">
                        <dcc-input name="spec_no"
                                   col="4"
                                   label="spec no."
                                   error="{{$errors->has("spec_no") ? $errors->first("spec_no"):""}}"
                                   value="{{old("spec_no")}}"
                        ></dcc-input>

                        <dcc-input name="name"
                                   col="8"
                                   label="title"
                                   error="{{$errors->has("name") ? $errors->first("name"):""}}"
                                   value="{{old("name")}}"
                        ></dcc-input>


                        <dcc-input name="document"
                                   col="4"
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
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{--=======================================MODALS=================================--}}
    <dcc-modal title="Modal confirmation" id="spec-submit">
        <h1>Are you sure you want to submit?</h1>
        <div class="text-center">
            <button type="button" class="btn btn-primary" data-dismiss="modal" @click="submitForm">Yes</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
        </div>
    </dcc-modal>
@endsection