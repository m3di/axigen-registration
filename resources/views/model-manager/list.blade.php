@extends('layouts.app-navbar')

@push('html-title', 'مدیریت '.$manager->getPluralFa())

@section('app-navbar-content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>مدیریت {{ $manager->getPluralFa() }}</strong>
                @if($returnAddress = $manager->getReturnAddress())
                    <a href="{{ $returnAddress }}" class="btn btn-default btn-xs pull-left">
                        <i class="fa fa-chevron-right"></i>
                        <span>بازگشت</span>
                    </a>
                @endif
            </div>
            <div class="panel-body">
                <a href="{{ route($manager->getRouteName('create'), $manager->getRouteParams()) }}" class="btn btn-success"><i class="fa fa-plus"></i> {{ $manager->getSingularFa() }} جدید</a>
                <hr />
                {!! \App\Helpers\message_block() !!}
                @include($manager->getViewDirectory().'.list')
            </div>
        </div>
    </div>
@endsection