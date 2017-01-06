@extends('layouts.app')
@push("style")
<style>
    body {
        overflow-y: auto;
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
          <li class="active"> New External Specification</li>
        </ol>

          @include('errors.flash')

        <div class="panel panel-{{$errors->any() ? "danger" : "default"}}">
            <div class="panel-heading">
              <h3 class="panel-title">Add new External Specification</h3>
            </div>
            <div class="panel-body">

                <form action="{{route('external.store')}}" method="post" enctype="multipart/form-data" id="form-submit">
                    {{ csrf_field() }}
                    <div class="row">
                        <dcc-input name="customer_name"
                                   col="4"
                                   label="customer name"
                                   list="external_customer"
                                   error="{{$errors->has("customer_name") ? $errors->first("customer_name"):""}}"
                                   value="{{old("customer_name")}}"
                        ></dcc-input>

                        <datalist id="external_customer">
                            <option v-for="category in {{$category_lists}}" :value="category.customer_name">
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

                    <div class="row">
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
                    </div>

                    <div class="row">
                        <dcc-input name="reviewer"
                                   col="4"
                                   list="reviewer_list"
                                   error="{{$errors->has("reviewer") ? $errors->first("reviewer"):""}}"
                                   value="{{old("reviewer")}}"
                        ></dcc-input>

                        <datalist id="reviewer_list" v-if="{{$reviewers_list}}">
                            <option v-for="reviewer in {{$reviewers_list}}" :value="reviewer">
                        </datalist>

                        <datalist id="reviewer_list" v-else>
                            <option value="QA">
                            <option value="PE">
                        </datalist>


                        <dcc-input name="document"
                                   col="8"
                                   type="file"
                                   error="{{$errors->has("document") ? $errors->first("document"):""}}"
                                   value="{{old("document")}}"
                        ></dcc-input>
                    </div>

                    <div class="row" v-show="requireDepartment">
                        <div class="col-md-12 form-group {{ $errors->has('cc') ? ' has-error' : '' }}">
                            <label for="cc" class="control-label">CC</label>

                            <departments name="cc"
                                         departments-list="{{App\Department::listDepartments()}}"
                                         value="{{json_encode(old("cc"))}}">
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
                                Submit <i class="fa fa-paper-plane"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@include('modal.confirmation')
@endsection