@extends('layouts.app')

@push('style')
<link rel="stylesheet" href="{{url("/css/external-edit.css")}}">
@endpush

@push('script')
<script src="{{url("/js/external-edit.js")}}"></script>
@endpush

@section('content')
    <div class="container">

        <ol class="breadcrumb">
            <li>
                <a href="{{route("home")}}">Home</a>
            </li>
            <li><a href="{{route("external.index")}}">External Specification</a></li>
            <li class="active">{{$spec->customerSpecCategory->customer_name}}</li>
            <li class="active">{{$spec->spec_no}} - {{$spec->name}}</li>
        </ol>

        <div class="panel panel-{{$errors->any() ? "danger" : "default"}}">
            <div class="panel-heading">
                <h3 class="panel-title">Update External Specification</h3>
            </div>
            <div class="panel-body">
                <form action="{{route("external.update",['internal' => $spec->id])}}" method="post"
                      enctype="multipart/form-data" id="form-submit">
                    {{ csrf_field() }}
                    {{ method_field('PATCH') }}
                    <input type="hidden" value="{{$spec->id}}" name="id">
                    <div class="container-fluid">

                        <dcc-input name="customer_name"
                                   col="4"
                                   label="customer name"
                                   list="external_customer"
                                   error="{{$errors->has("customer_name") ? $errors->first("customer_name"):""}}"
                                   value="{{$errors->has("customer_name") || old("customer_name")
                                   ? old("customer_name") :  $spec->customerSpecCategory->customer_name}}"
                        ></dcc-input>

                        <datalist id="external_customer">
                            <option v-for="category in {{$categories}}" value="@{{ category.customer_name }}">
                        </datalist>

                        <dcc-input name="revision"
                                   col="4"
                                   error="{{$errors->has("revision") ? $errors->first("revision"):""}}"
                                   value="{{$errors->has("revision") || old("revision")
                                       ? old("revision")
                                       :  collect($spec->customerSpecRevision)->sortBy("revision")->last()->revision}}"
                        ></dcc-input>

                        <dcc-datepicker name="revision_date"
                                        col="4"
                                        label="date"
                                        error="{{$errors->has("revision_date") ? $errors->first("revision_date"):""}}"
                                        value="{{$errors->has("revision_date") || old("revision_date")
                                            ? old("revision_date")
                                            : collect($spec->customerSpecRevision)->sortBy("revision")->last()->revision_date}}"
                        ></dcc-datepicker>
                    </div>

                    <dcc-input name="spec_no"
                               col="4"
                               label="spec no."
                               error="{{$errors->has("spec_no") ? $errors->first("spec_no"):""}}"
                               value="{{$errors->has("spec_no") || old("spec_no") ? old("spec_no") :  $spec->spec_no}}"
                    ></dcc-input>

                    <dcc-input name="name"
                               col="8"
                               label="title"
                               error="{{$errors->has("name") ? $errors->first("name"):""}}"
                               value="{{$errors->has("name") || old("name") ? old("name") :  $spec->name}}"
                    ></dcc-input>

                    <dcc-input name="document"
                               col="4"
                               type="file"
                               error="{{$errors->has("document") ? $errors->first("document"):""}}"
                               value="{{$errors->has("document") || old("document") ? old("document") :  $spec->document}}"
                    ></dcc-input>

                    <div class="col-md-12">
                        <button type="button"
                                class="btn pull-right btn-{{$errors->any() ? "danger" : "primary"}}"
                                data-toggle="modal"
                                href="#spec-update"
                        >
                            Save <i class="fa fa-floppy-o"></i>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    {{--=======================================MODALS=================================--}}
    <dcc-modal title="Modal confirmation" id="spec-update">
        <h1>Are you sure you want to submit?</h1>
        <div class="text-center">
            <button type="button" class="btn btn-primary" data-dismiss="modal" @click="submitForm">Yes</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
        </div>
    </dcc-modal>
@endsection