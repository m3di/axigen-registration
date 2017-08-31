@extends('layouts.app-navbar')

@push('html-title', 'مدیریت '.$manager->getPluralFa())

@section('app-navbar-content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>ویرایش {{ $fa['single'] }}</strong>
                <a href="{{ route("{$routePrefix}{$en['single']}.list", $routeParams) }}" class="btn btn-default btn-xs pull-left">
                    <i class="fa fa-chevron-right"></i>
                    <span>بازگشت</span>
                </a>
            </div>
            <div class="panel-body">
                {!! BootForm::horizontal(isset($formOptions) ? $formOptions : []) !!}

                @include($viewDir.'.edit')

                {!! BootForm::button('<i class="fa fa-save"></i> تایید و ویرایش '.$fa['single'], ['type' => 'submit']) !!}

                {!! BootForm::close() !!}
            </div>
        </div>
    </div>
@endsection