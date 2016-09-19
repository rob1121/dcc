
@extends('layouts.app')

@push("style")
    <link rel="stylesheet" href="{{url("/css/internal-create.css")}}">
@endpush

@push("script")
    <script src="{{url("/js/internal-create.js")}}"></script>
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

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Add new Internal Specification</h3>
            </div>
            <div class="panel-body">
                <form action="{{route('internal.store')}}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <dcc-input name="category_no"
                               col="4"
                               label="category no."
                               error="{{$errors->has("category_no") ? $errors->first("category_no"):""}}"
                               value="{{old("category_no")}}"
                    ></dcc-input>

                    <dcc-input name="category_name"
                               col="8"
                               label="category name"
                               error="{{$errors->has("category_name") ? $errors->first("category_name"):""}}"
                               value="{{old("category_name")}}"
                    ></dcc-input>

                    <dcc-input name="spec_no"
                               col="4"
                               label="spec no."
                               error="{{$errors->has("spec_no") ? $errors->first("spec_no"):""}}"
                               value="{{old("spec_no")}}"
                    ></dcc-input>

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

                    <dcc-textarea name="revision_summary"
                                  label="revision summary"
                                  error="{{$errors->has("revision_summary") ? $errors->first("revision_summary"):""}}"
                                  value="{{old("revision_summary")}}"
                    ></dcc-textarea>
                    <dcc-button icon="paper-plane">Submit</dcc-button>
                </form>
            </div>
        </div>
    </div>
@endsection