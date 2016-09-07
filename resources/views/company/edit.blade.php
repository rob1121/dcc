@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Update Internal Specification</h3>
            </div>
            <div class="panel-body">
                <form action="{{route("internal.update",['internal' => $spec->id])}}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('PATCH') }}

                    <dcc-input name="category_no"
                               col="4"
                               label="category no."
                               error="{{$errors->has("category_no") ? $errors->first("category_no"):""}}"
                               value="{{$errors->has("category_no") || old("category_no") ? old("category_no") :  $spec->companySpecCategory->category_no}}"
                    ></dcc-input>

                    <dcc-input name="category_name"
                               col="8"
                               label="category name"
                               error="{{$errors->has("category_name") ? $errors->first("category_name"):""}}"
                               value="{{$errors->has("category_name") || old("category_name") ? old("category_name") :  $spec->companySpecCategory->category_name}}"
                    ></dcc-input>

                    <dcc-input name="spec_no"
                               col="4"
                               label="spec no."
                               error="{{$errors->has("spec_no") ? $errors->first("spec_no"):""}}"
                               value="{{$errors->has("spec_no") || old("spec_no") ? old("spec_no") :  $spec->spec_no}}"
                    ></dcc-input>

                    <dcc-input name="revision"
                               col="4"
                               error="{{$errors->has("revision") ? $errors->first("revision"):""}}"
                               value="{{$errors->has("revision") || old("revision") ? old("revision") :  $spec->companySpecRevision->revision}}"
                    ></dcc-input>

                    <dcc-datepicker name="revision_date"
                                    col="4"
                                    label="date"
                                    error="{{$errors->has("revision_date") ? $errors->first("revision_date"):""}}"
                                    value="{{$errors->has("revision_date") || old("revision_date") ? old("revision_date") :  $spec->companySpecRevision->revision_date}}"
                    ></dcc-datepicker>

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

                    <dcc-textarea name="revision_summary"
                                  label="revision summary"
                                  error="{{$errors->has("revision_summary") ? $errors->first("revision_summary"):""}}"
                                  value="{{$errors->has("revision_summary") || old("revision_summary") ? old("revision_summary") :  $spec->companySpecRevision->revision_summary}}"
                    ></dcc-textarea>
                    <dcc-button icon="floppy-disk">Save</dcc-button>
                </form>
            </div>
        </div>
    </div>
@endsection