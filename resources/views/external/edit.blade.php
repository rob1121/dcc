@extends('layouts.app')
@push("style")
<style>
    body {
        overflow-y: scroll
    }
</style>
@endpush

@push('script')
<script src="{{URL::to("/js/external-edit.js")}}"></script>
@endpush

@section('content')
    <div class="col-md-6 col-md-offset-3" style="margin-top: 10px">

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
                    <input type="hidden" value="{{collect($spec->customerSpecRevision)->last()->reviewer}}" name="reviewer">
                    <div class="row">

                        <dcc-input name="customer_name"
                                   col="4"
                                   label="customer name"
                                   list="external_customer"
                                   error="{{$errors->first("customer_name")}}"
                                   value="{{old("customer_name") ?:  $spec->customerSpecCategory->customer_name}}"
                        ></dcc-input>

                        <datalist id="external_customer">
                            <option v-for="category in {{$category_lists}}" :value="category.customer_name">
                        </datalist>

                        <dcc-input name="revision"
                                   col="4"
                                   error="{{$errors->first("revision")}}"
                                   value="{{old("revision") ?: collect($spec->customerSpecRevision)->sortBy("revision")->last()->revision}}"
                        ></dcc-input>

                        <div class="col-sm-4 form-group {{ $errors->has('revision_date') ? ' has-error' : '' }}">
                            <label for="revision_date" class="control-label">Date</label>
                            <dcc-datepicker name="revision_date"
                                            error="{{$errors->first("revision_date")}}"
                                            value="{{old("revision_date")?: collect($spec->customerSpecRevision)->sortBy("revision")->last()->revision_date}}"
                            ></dcc-datepicker>
                        </div>
                    </div>
                    <div class="row">
                        <dcc-input name="spec_no"
                                   col="4"
                                   label="spec no."
                                   error="{{$errors->first("spec_no")}}"
                                   value="{{old("spec_no") ?:  $spec->spec_no}}"
                        ></dcc-input>

                        <dcc-input name="name"
                                   col="8"
                                   label="title"
                                   error="{{$errors->first("name")}}"
                                   value="{{old("name") ?:  $spec->name}}"
                        ></dcc-input>
                    </div>
                    <div class="row">

                        <dcc-input name="reviewer"
                                   col="4"
                                   list="reviewer_list"
                                   error="{{$errors->first("reviewer")}}"
                                   value="{{old("reviewer") ?:  $spec->reviewer}}"
                        ></dcc-input>

                        <datalist id="reviewer_list" v-if="{{$reviewers_list}}">
                            <option v-for="reviewer in {{$reviewers_list}}" :value="reviewer">
                        </datalist>

                        <dcc-input name="document"
                                   col="8"
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
                        <div class="col-md-12">
                            <button type="button"
                                    class="btn pull-right btn-{{$errors->any() ? "danger" : "primary"}}"
                                    data-toggle="modal"
                                    href="#spec-submit"
                            >
                                Save <i class="fa fa-floppy-o"></i>
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

@include('modal.confirmation');
@endsection
