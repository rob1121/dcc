@extends('layouts.app')

@push('script')
    <script src="{{url("/js/form.js")}}"></script>
@endpush

@section('content')
    <div class="hidden-xs col-md-3 side">
        <ul class="sidebar">
            <li><a href="#dcc-online">What is DCC Online?</a></li>
            <li><a href="#dcc-online2">What is DCC Online?</a></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </ul>
    </div>

    <div class="col-xs-12 col-md-9 main-content">
        <div class="panel panel-default" id="dcc-online">
            <div class="panel-body">
                <h3>DCC ONLINE</h3>
                <hr>
                <p>DCC Online is the Telford Svc. Phils., Inc. online document center that aims to cost cut the use paper by making printed documents into an electronic documents.</p>
            </div>
        </div>

        <div class="panel panel-default" id="dcc-online2">
            <div class="panel-body">
                <h3>DCC ONLINE</h3>
                <hr>
                <p>DCC Online is the Telford Svc. Phils., Inc. online document center that aims to cost cut the use paper by making printed documents into an electronic documents.</p>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-body">
                <h3 id="dcc-online2">DCC ONLINE</h3>
                <hr>
                <p>DCC Online is the Telford Svc. Phils., Inc. online document center that aims to cost cut the use paper by making printed documents into an electronic documents.</p>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-body">
                <h3 id="dcc-online2">DCC ONLINE</h3>
                <hr>
                <p>DCC Online is the Telford Svc. Phils., Inc. online document center that aims to cost cut the use paper by making printed documents into an electronic documents.</p>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-body">
                <h3 id="dcc-online2">DCC ONLINE</h3>
                <hr>
                <p>DCC Online is the Telford Svc. Phils., Inc. online document center that aims to cost cut the use paper by making printed documents into an electronic documents.</p>
            </div>
        </div>
    </div>
@endsection
