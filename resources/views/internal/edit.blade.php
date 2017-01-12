@extends('layouts.app')
@push("style")
    <style>
        body {
            overflow: scroll
        }
    </style>
@endpush
@push('script')
    <script src="{{URL::to("/js/external-edit.js")}}"></script>
@endpush

@section('content')
    <div class="col-md-6 col-md-offset-3" style="margin-top: 10px;">

        <ol class="breadcrumb">
            <li><a href="{{route("home")}}">Home</a></li>
            <li><a href="{{route("internal.index")}}">Internal Specification</a></li>
            <li class="active">{{$spec->companySpecCategory->category_title}}</li>
            <li class="active">{{$spec->spec_name}}</li>
        </ol>

        <div class="panel panel-{{$errors->any() ? "danger" : "default"}}">
            <div class="panel-heading">
                <h3 class="panel-title"><strong>{{$spec->spec_name}}</strong></h3>
            </div>
            <div class="panel-body">
                <form action="{{route("internal.update",['internal' => $spec->id])}}" method="post" enctype="multipart/form-data" id="form-submit">
                    {{ csrf_field() }}
                    {{ method_field('PATCH') }}
                    <input type="hidden" value="{{$spec->id}}" name="id">
                    <div class="row">
                        <dcc-input name="name"
                                   col="12"
                                   label="title"
                                   error="{{$errors->first("name")}}"
                                   value="{{old("name") ?:  $spec->name}}"
                        ></dcc-input>
                    </div>

                    <div class="row">
                        <dcc-input name="revision"
                                   col="4"
                                   error="{{$errors->first("revision")}}"
                                   value="{{old("revision") ?:  $spec->companySpecRevision->revision}}"
                        ></dcc-input>

                        <div class="col-sm-3 form-group {{ $errors->has('revision_date') ? ' has-error' : '' }}">
                            <label for="revision_date" class="control-label">Date</label>
                            <dcc-datepicker name="revision_date"
                                            error="{{$errors->first("revision_date")}}"
                                            value="{{old("revision_date")}}"
                            ></dcc-datepicker>
                        </div>

                        <dcc-input name="document"
                                   col="4"
                                   type="file"
                                   error="{{$errors->first("document")}}"
                                   value="{{old("document") ?:  $spec->document}}"
                        ></dcc-input>
                    </div>

                    <div class="row" v-show="requireDepartment">
                        <div class="col-md-12 form-group {{ $errors->has('cc') ? ' has-error' : '' }}">
                            <label for="cc" class="control-label">CC</label>
                            <departments name="cc"
                                         value="{{json_encode(old("cc")?:$spec->cc)}}">
                            </departments>

                            <h6 class="help-block">
                                <strong>{{ $errors->first('cc') }}</strong>
                            </h6>
                        </div>
                    </div>

                    <div class="radio col-xs-12 row form-group">
                        <label class="control-label">
                            <input type="radio"
                                   value="true"
                                   name="send_notification"
                                   id="send_notification"
                            @change="getSendNotification"
                            @if(old("send_notification") !== "false") checked @endif>
                            Notify everyone for new internal specification
                        </label>
                    </div>

                    <div class="radio col-xs-12 row form-group">
                        <label class="control-label">
                            <input type="radio"
                                   name="send_notification"
                                   id="send_notification"
                                   value="false"
                            @change="getSendNotification"
                            @if(old("send_notification") === "false") checked @endif>
                            Skip email notification
                        </label>
                    </div>

                    <div class="row">
                        <dcc-textarea name="revision_summary"
                                      label="Revision Summary"
                                      error="{{$errors->first("revision_summary")}}"
                                      value="{{old("revision_summary") ?:  $spec->companySpecRevision->revision_summary }}"
                        ></dcc-textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <button type="button"
                                    class="btn pull-right btn-{{$errors->any() ? "danger" : "primary"}}"
                                    data-toggle="modal"
                                    href="#spec-submit"
                            >
                                Save <i class="fa fa-fa-floppy-o"></i>
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@include('modal.confirmation');
@endsection
