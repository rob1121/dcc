@extends('layouts.app')

@push("style")
<style>
    #app {
        padding-top: 64px;
        overflow-y: scroll;
    }
</style>
@endpush

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
    <div class="container">

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
                    <div class="form-group col-sm-12 @if($errors->has("category_no") || $errors->has("category_name")) has-error @endif">
                        <label class="control-label">Specification Category</label>
                        <select name="category" id="category" class="form-control input-sm">
                            <option value="" selected disabled> -- Select One -- </option>

                            <option v-for="category in {{$categories}}"
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

                    <div class="category-group hidden">
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
                               col="2"
                               error="{{$errors->has("revision") ? $errors->first("revision"):""}}"
                               value="{{old("revision")}}"
                    ></dcc-input>

                    <dcc-datepicker name="revision_date"
                                    col="2"
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

                    <dcc-textarea name="revision_summary"
                                  label="revision summary"
                                  error="{{$errors->has("revision_summary") ? $errors->first("revision_summary"):""}}"
                                  value="{{old("revision_summary")}}"
                    ></dcc-textarea>
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

    {{--=======================================MODALS=================================--}}
    <dcc-modal title="Modal confirmation" id="spec-submit">
        <h1>Are you sure you want to submit?</h1>
        <div class="text-center">
            <button type="button" class="btn btn-primary" data-dismiss="modal" @click="submitForm">Yes</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
        </div>
    </dcc-modal>
@endsection