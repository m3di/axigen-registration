@extends('layouts.html')

@push('html-metas')
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@push('html-styles')
<link rel="stylesheet" href="{{ asset('/resources/css/app.css') }}">
@endpush

@push('html-scripts')
<script type="text/javascript" src="{{ asset('/resources/js/app.js') }}"></script>
@endpush

@section('html-body')
@yield('app-content')
@endsection
