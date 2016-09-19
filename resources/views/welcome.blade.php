@extends('layouts.app')

@push("style")
    <link rel="stylesheet" href="{{url("/css/app.css")}}">
@endpush

@push("script")
    <script src="{{url("/js/app.js")}}"></script>
@endpush

@section("content")
    <div class="container" style="padding-top: 64px">
        <h1>DCC Online</h1>
    </div>
@endsection