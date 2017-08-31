@extends('layouts.app')

@section('app-content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h2 class="text-center" id="page-header">
                    <img src="/resources/images/razi-logo.png" alt="" class="center-block">
                </h2>
                <div class="panel with-nav-tabs panel-default">
                    <div class="panel-heading">
                        <div class="text-center" id="reg-panel-header">
                            <h4>درگاه ثبت درخواست ایجاد ایمیل دانشجویان و اساتید دانشگاه رازی</h4>
                        </div>

                        <ul class="nav nav-tabs nav-justified" id="tabs">
                            <li class="active"><a href="#tab1" data-toggle="tab">دانشجویان کارشناسی</a></li>
                            <li><a href="#tab2" data-toggle="tab">دانشجویان تحصیلات تکمیلی</a></li>
                            <li><a href="#tab3" data-toggle="tab">اساتید</a></li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <div class="tab-content">
                            <div class="tab-pane fade in active student-info" id="tab1">
                                {!! BootForm::open() !!}

                                {!! BootForm::hidden('g-recaptcha-response') !!}

                                {!! BootForm::text('name', 'نام و نام خانوادگی') !!}

                                {!! BootForm::number('sid', 'شماره دانشجویی') !!}

                                {!! BootForm::tel('tel', 'شماره همراه') !!}

                                {!! BootForm::checkbox('terms', new \Illuminate\Support\HtmlString('ضمن مطالعه دقیق '.'<a href="#">قوانین</a>'.' و '.'<a href="#">شرایط</a>'.'، با همه موارد موافقم')) !!}

                                {!! BootForm::submit('ثبت درخواست') !!}

                                {!! BootForm::close() !!}
                            </div>
                            <div class="tab-pane fade student-info" id="tab2">
                                <form id="register-form" action="https://phpoll.com/register/process"
                                      method="post" role="form">
                                    <div class="form-group">
                                        <input type="text" name="username" id="username" tabindex="1"
                                               class="form-control" placeholder="Username" value="">
                                    </div>
                                    <div class="form-group">
                                        <input type="email" name="email" id="email" tabindex="1"
                                               class="form-control" placeholder="Email Address" value="">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" id="password" tabindex="2"
                                               class="form-control" placeholder="Password">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="confirm-password" id="confirm-password"
                                               tabindex="2" class="form-control"
                                               placeholder="Confirm Password">
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6 col-sm-offset-3">
                                                <input type="submit" name="register-submit"
                                                       id="register-submit" tabindex="4"
                                                       class="form-control btn btn-register"
                                                       value="Register Now">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade student-info" id="tab3">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="captcha-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">جلوگیری از ربات اسپم</h4>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        {!! app('captcha')->display(['data-callback' => 'captchaCallback'], 'fa') !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">انصراف</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function () {
            var tabs = $('#tabs');

            tabs.find('a').click(function (e) {
                e.preventDefault();
            });

            $("ul.nav-tabs > li > a").on("shown.bs.tab", function (e) {
                var hash = '!' + $(e.target).attr("href").substr(1);
                if (hash === '!tab1')
                    hash = '';
                window.location.hash = hash;
            });

            $(window).on('hashchange', function (e) {
                var hash = window.location.hash || '#!tab1';
                tabs.find('a[href="' + hash.replace(/^#!/, '#') + '"]').tab('show');
            }).trigger('hashchange');
        });

        var reservedForm = null, c_token = null;
        $('form').submit(function (e) {
            if (c_token === null) {
                e.preventDefault();
                reservedForm = $(this);
                $('#captcha-modal').modal('show');
            } else {
                $(this).find('[name=g-recaptcha-response]').val(c_token);
            }
        });

        function captchaCallback(response) {
            c_token = response;
            reservedForm && reservedForm.submit();
        }
    </script>
@endsection