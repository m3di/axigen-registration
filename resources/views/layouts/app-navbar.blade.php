@extends('layouts.app')

@section('app-content')
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-navbar-navigation">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ url('/') }}" tabindex="-1">{{ config('app.name') }}</a>
            </div>

            <div class="collapse navbar-collapse" id="main-navbar-navigation">
                {{--@if (auth()->check())--}}
                    {{--<ul class="nav navbar-nav">--}}
                        {{--@foreach(Auth::user()->roles as $role)--}}
                            {{--<li><a href="{{ url('/panel/'.$role->name) }}" tabindex="-1">{{ $role->display_name }}</a></li>--}}
                        {{--@endforeach--}}
                    {{--</ul>--}}
                {{--@endif--}}

                <ul class="nav navbar-nav navbar-left">
                    @if (auth()->guest())
                        <li><a href="{{ url('/login') }}" tabindex="-1">ورود</a></li>
                        <li><a href="{{ url('/register') }}" tabindex="-1">عضویت</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" tabindex="-1">{{ Auth::user()->name }} <span class="caret"></span></a>
                            <ul class="dropdown-menu pull-right" role="menu">
                                <li><a onclick="event.preventDefault();document.getElementById('logout-form').submit();" href="{{ route('logout') }}" tabindex="-1">خروج</a></li>
                            </ul>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @yield('app-navbar-content')
@endsection