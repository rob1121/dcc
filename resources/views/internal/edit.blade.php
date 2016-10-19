@extends('layouts.app')

@push('script')
    <script src="{{URL::to("/js/form.js")}}"></script>

    <script>
        var chosen = $(".chosen-select");

        chosen.chosen({
            disable_search_threshold: 10,
            no_results_text: "Oops, nothing found!",
            max_selected_options: 5,
            display: "block",
            width: "100%",
        });

        chosen.val(
                {!! old("department") ? collect(old("department"))->toJson() : collect($spec->originator_departments)->toJson()  !!}
        ).trigger("chosen:updated");

        $("input[name='send_notification']").on('change', function() {
            var department = $(".department");

            if( $(this).val() === "true" ) department.show();
            else department.hide();
        });
    </script>
@endpush

@section('content')
    <div class="form">

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
                                   error="{{$errors->has("name") ? $errors->first("name"):""}}"
                                   value="{{$errors->has("name") || old("name") ? old("name") :  $spec->name}}"
                        ></dcc-input>
                    </div>

                    <div class="row">
                        <dcc-input name="revision"
                                   col="4"
                                   error="{{$errors->has("revision") ? $errors->first("revision"):""}}"
                                   value="{{$errors->has("revision") || old("revision") ? old("revision") :  $spec->companySpecRevision->revision}}"
                        ></dcc-input>

                        <dcc-datepicker name="revision_date"
                                        col="4"
                                        label="date"
                                        error="{{$errors->has("revision_date") ? $errors->first("revision_date"):""}}"
                                        value="{{$errors->has("revision_date") || old("revision_date")
                                        ? old("revision_date") :  $spec->companySpecRevision->revision_date}}"
                        ></dcc-datepicker>

                        <dcc-input name="document"
                                   col="4"
                                   type="file"
                                   error="{{$errors->has("document") ? $errors->first("document"):""}}"
                                   value="{{$errors->has("document") || old("document") ? old("document") :  $spec->document}}"
                        ></dcc-input>
                    </div>

                    <div class="row">
                        <div class="radio col-xs-12 form-group">
                            <label class="control-label">
                                <input type="radio"
                                       value="true"
                                       id="send_notification"
                                       name="send_notification"
                                       @if(old("send_notification") !== "false") checked @endif
                                >
                                Notify everyone for update of internal specification
                            </label>
                        </div>

                        <div class="radio col-xs-12 form-group">
                            <label class="control-label">
                                <input type="radio"
                                       name="send_notification"
                                       id="send_notification"
                                       value="false"
                                       @if(old("send_notification") === "false") checked @endif
                                >
                                Skip email notification
                            </label>
                        </div>
                    </div>

                    <div class="department row-fluid form-group {{$errors->has("department") ? "has-error" : ""}}">
                        <label class="control-label"><strong>Department </strong></label>
                        <br>
                        <select data-placeholder="Choose department" multiple class="chosen-select" name="department[]" hidden>
                            @foreach($departments as $department)
                                <option>{{$department}}</option>
                            @endforeach
                        </select>
                        <span class="help-block">{{$errors->has("department") ? $errors->first("department"):""}}</span>
                    </div>

                    <div class="row">
                        <dcc-textarea name="revision_summary"
                                      label="Revision Summary"
                                      error="{{$errors->has("revision_summary") ? $errors->first("revision_summary"):""}}"
                                      value="{{$errors->has("revision_summary") || old("revision_summary")
                                      ? old("revision_summary") :  $spec->companySpecRevision->revision_summary }}"
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
