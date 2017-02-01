@extends('layouts.app')
@push("style")
<style>
    body {
        overflow: scroll
    }
</style>
@endpush

@push("script")
    <script src="{{URL::to("/js/internal-edit.js")}}"></script>
@endpush

@section('content')
    <div class="col-md-6 col-md-offset-3" style="margin-top: 10px">
        <ol class="breadcrumb">
            <li>
                <a href="{{route("home")}}">Home</a>
            </li>
            <li><a href="{{route("internal.index")}}">Internal Specification</a></li>
            <li class="active"> New Internal Specification</li>
        </ol>

          @include('errors.flash')

        <div class="panel panel-{{$errors->any() ? "danger" : "default"}}">
            <div class="panel-heading">
                <h3 class="panel-title">Add new Internal Specification</h3>
            </div>
            <div class="panel-body">
                <form action="{{route('internal.store')}}" method="post" enctype="multipart/form-data" id="form-submit">
                    {{ csrf_field() }}
                    <div class="row">

                        <div class="form-group col-xs-12 @if($errors->has("category_no") || $errors->has("category_name")) has-error @endif">
                            <label class="control-label">Specification Category</label>
                            <select name="category" id="category" class="form-control input-sm" @change="toggleCategoryInputField($event.target)">
                                <option v-for="category in {{$category_lists}}"
                                        :value="category.category_no"
                                        :selected="'{{old("category")}}' == category.category_no"
                                >
                                    @{{ category.category_title }}
                                </option>

                                <option value="add_category" {{old("category")==="add_category"?"selected":""}}>
                                    -- Input new category --
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="category-group row" id="categoryInput">
                            <dcc-input name="category_no"
                                       col="4"
                                       label="category no."
                                       error="{{$errors->first("category_no")}}"
                                       value="{{old("category_no")}}"
                            ></dcc-input>

                            <dcc-input name="category_name"
                                       col="8"
                                       label="category name"
                                       error="{{$errors->first("category_name")}}"
                                       value="{{old("category_name")}}"
                            ></dcc-input>
                    </div>

                    <div class="row">
                        <dcc-input name="name"
                                   col="12"
                                   label="title"
                                   error="{{$errors->first("name")}}"
                                   value="{{old("name")}}"
                        ></dcc-input>
                    </div>

                    <div class="row">
                        <dcc-input name="revision"
                                   col="2"
                                   error="{{$errors->first("revision")}}"
                                   value="{{old("revision")}}"
                        ></dcc-input>

                        <div class="col-sm-3 form-group {{ $errors->has('revision_date') ? ' has-error' : '' }}">
                            <label for="revision_date" class="control-label">Date</label>
                            <dcc-datepicker name="revision_date"
                                            error="{{$errors->first("revision_date")}}"
                                            value="{{old("revision_date")}}"
                            ></dcc-datepicker>
                        </div>

                        <dcc-input name="document"
                                   col="7"
                                   type="file"
                                   error="{{$errors->first("document")}}"
                                   value="{{old("document")}}"
                        ></dcc-input>
                    </div>

                    <div class="col-md-12 row form-group">
                        <checkbox name="send_notification"
                                  v-model="requireDepartment"
                                  init="{{old("send_notification")}}"
                                  label="Notify everyone for new internal specification"
                        >
                    </div>

                    <div class="row" v-show="requireDepartment">
                        <div class="col-md-12 form-group {{ $errors->has('cc') ? ' has-error' : '' }}">
                            <label for="cc" class="control-label">CC</label>
                            <departments name="cc"
                                         value="{{json_encode(old("cc"))}}">
                            </departments>

                            <h6 class="help-block">{{ $errors->first('cc') }}</h6>
                        </div>
                    </div>

                    <div class="row">

                        <dcc-textarea name="revision_summary"
                                      label="Revision Summary"
                                      error="{{$errors->first("revision_summary")}}"
                                      value="{{old("revision_summary")}}"
                        ></dcc-textarea>
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