@extends('layouts.app-navbar')

@push('html-title', 'مدیریت '.$manager->getPluralFa())

@section('app-navbar-content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>{{ $manager->getSingularFa() }} جدید</strong>
                <a href="{{ route($manager->getRouteName('list'), $manager->getRouteParams()) }}" class="btn btn-default btn-xs pull-left">
                    <i class="fa fa-chevron-right"></i>
                    <span>بازگشت</span>
                </a>
            </div>
            <div class="panel-body">
                {!! BootForm::horizontal(isset($formOptions) ? $formOptions : []) !!}

                @include($manager->getViewDirectory().'.create')

                {!! BootForm::button('<i class="fa fa-save"></i> تایید و ثبت '.$manager->getSingularFa().' جدید', ['type' => 'submit']) !!}

                {!! BootForm::close() !!}
            </div>
        </div>
    </div>
@endsection