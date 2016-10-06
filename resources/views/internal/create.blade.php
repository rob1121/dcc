@extends('layouts.app')

@push("script")
    <script src="{{URL::to("/js/create.js")}}"></script>

    <script>
        function toggleCategory(selected) {
            if( "add_category" === selected.val() ) {
                $("#category_no").val("");
                $("#category_name").val("");
                $(".category-group").removeClass("hidden");
            } else {
                $("#category_no").val(selected.val());
                $("#category_name").val(selected.data("name"));
                $(".category-group").addClass("hidden");
            }

        }

        if($("option:selected").val() === "add_category")
            $(".category-group").removeClass("hidden");

        $('#category').on("change", function() {
            toggleCategory($('option:selected'));
        });
    </script>
@endpush

@section('content')
    <div class="col-xs-10">

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
                            <select name="category" id="category" class="form-control input-sm">
                                <option value="" selected disabled> -- Select One -- </option>

                                <option v-for="category in {{$category_lists}}"
                                        :value="category.category_no"
                                        :data-name="category.category_name"
                                        :selected="'{{old("category")}}' == category.category_no"
                                >
                                    @{{ category.category_no }} - @{{ category.category_name }}
                                </option>

                                <option value="add_category" :selected="'{{old("category")}}' === 'add_category'">
                                    -- Input new category --
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="category-group hidden row">
                            <dcc-input name="category_no"
                                       col="4"
                                       label="category no."
                                       list="category_list"
                                       error="{{$errors->has("category_no") ? $errors->first("category_no"):""}}"
                                       value="{{old("category_no")}}"
                            ></dcc-input>

                            <dcc-input name="category_name"
                                       col="8"
                                       label="category name"
                                       list="category_list_name"
                                       error="{{$errors->has("category_name") ? $errors->first("category_name"):""}}"
                                       value="{{old("category_name")}}"
                            ></dcc-input>
                    </div>

                    <div class="row">

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
                    </div>

                    <div class="row">
                        <dcc-input name="revision"
                                   col="2"
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
                                   col="5"
                                   type="file"
                                   error="{{$errors->has("document") ? $errors->first("document"):""}}"
                                   value="{{old("document")}}"
                        ></dcc-input>
                    </div>
                    <div class="radio col-xs-12 row form-group">
                        <label class="control-label">
                            <input type="radio"
                                   value="true"
                                   id="notify_all"
                                   name="notify_all"
                                   @if(old("notify_all") !== "false") checked @endif
                            >
                            Create and notify everyone for new internal specification
                        </label>
                    </div>
                    <div class="radio col-xs-12 row form-group">
                        <label class="control-label">
                            <input type="radio"
                                   name="notify_all"
                                   id="notify_all"
                                   value="false"
                                   @if(old("notify_all") === "false") checked @endif
                            >
                            Skip email notification
                        </label>
                    </div>

                    <div class="row">

                        <dcc-textarea name="revision_summary"
                                      label="revision summary"
                                      error="{{$errors->has("revision_summary") ? $errors->first("revision_summary"):""}}"
                                      value="{{old("revision_summary")}}"
                        ></dcc-textarea>
                    </div>

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

@include('modal.confirmation');
@endsection