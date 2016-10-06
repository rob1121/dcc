@extends('layouts.app')

@push('script')
    <script src="{{URL::to("/js/edit.js")}}"></script>
@endpush

@section('content')
    <div class="col-xs-10">

        <ol class="breadcrumb">
            <li> <a href="{{route("home")}}">Home</a> </li>
            <li><a href="{{route("iso.index")}}">ISO Document</a></li>
            <li class="active">{{$iso->spec_no}} - {{$iso->name}}</li>
        </ol>

        <div class="panel panel-{{$errors->any() ? "danger" : "default"}}">
            <div class="panel-heading">
                <h3 class="panel-title">Update ISO Document</h3>
            </div>

            <div class="panel-body">
                <form id="form-submit"
                      action="{{route("iso.update",['iso' => $iso->id])}}"
                      method="post"
                      enctype="multipart/form-data"
                >
                    {{ csrf_field() }}
                    {{ method_field('PATCH') }}

                    <dcc-input name="spec_no"
                               col="4"
                               label="spec no."
                               error="{{$errors->has("spec_no") ? $errors->first("spec_no"):""}}"
                               value="{{$errors->has("spec_no") || old("spec_no") ? old("spec_no") :  $iso->spec_no}}"
                    ></dcc-input>

                    <dcc-input name="revision"
                               col="4"
                               error="{{$errors->has("revision") ? $errors->first("revision"):""}}"
                               value="{{$errors->has("revision") || old("revision") ? old("revision") :  $iso->revision}}"
                    ></dcc-input>

                    <dcc-datepicker name="revision_date"
                                    col="4"
                                    label="date"
                                    error="{{$errors->has("revision_date") ? $errors->first("revision_date"):""}}"
                                    value="{{$errors->has("revision_date") || old("revision_date")
                                        ? old("revision_date") :  $iso->revision_date}}"
                    ></dcc-datepicker>

                    <dcc-input name="name"
                               col="8"
                               label="title"
                               error="{{$errors->has("name") ? $errors->first("name"):""}}"
                               value="{{$errors->has("name") || old("name") ? old("name") :  $iso->name}}"
                    ></dcc-input>

                    <dcc-input name="document"
                               col="4"
                               type="file"
                               error="{{$errors->has("document") ? $errors->first("document"):""}}"
                               value="{{$errors->has("document") || old("document") ? old("document") : ""}}"
                    ></dcc-input>

                    <div class="col-md-12">
                        <button type="button"
                                class="btn pull-right btn-{{$errors->any() ? "danger" : "primary"}}"
                                data-toggle="modal"
                                href="#spec-submit"
                        >
                            Save <i class="fa fa-fa-floppy-o"></i>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@include('modal.confirmation')
@endsection
