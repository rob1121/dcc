@extends("layouts.app")

@push("script") <script src="{{URL::to("/js/internal-index.js")}}"></script> @endpush

@section('content')
        <div class="hidden-xs col-md-4" style="background: #555555">col-md-4</div>
        <div class="col-xs-12 col-md-8" style="background: #aaa">col-md-8</div>
@endsection
