@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="{{URL::to("/css/external-for_review.css")}}">
@endpush

@push('script')
    <script src="{{URL::to("/js/external-for_review.js")}}">
@endpush
 
@section('content')
    @foreach($for_reviews as $for_review)
        <li>{{$for_review}}</li>
    @endforeach
@endsection
