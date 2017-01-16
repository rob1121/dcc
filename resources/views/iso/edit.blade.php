@extends('layouts.app')
@push("style")
<style>
    body {
        overflow: scroll
    }
</style>
@endpush

@push('script')
    <script src="{{URL::to("/js/form.js")}}"></script>
@endpush

@section('content')
    <div class="col-md-6 col-md-offset-3" style="margin-top: 10px">

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
                    <input type="hidden" value="{{$iso->id}}" name="id">
                    <div class="row">
                        <dcc-input name="spec_no"
                                   col="4"
                                   label="spec no."
                                   error="{{$errors->first("spec_no")}}"
                                   value="{{old("spec_no")?:  $iso->spec_no}}"
                        ></dcc-input>
                    </div>

                    <div class="row">
                        <dcc-input name="name"
                                   col="8"
                                   label="title"
                                   error="{{$errors->first("name")}}"
                                   value="{{old("name")?:  $iso->name}}"
                        ></dcc-input>

                        <dcc-input name="document"
                                   col="4"
                                   type="file"
                                   error="{{$errors->first("document")}}"
                                   value="{{old("document")}}"
                        ></dcc-input>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
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

@include('modal.confirmation')
@endsection
