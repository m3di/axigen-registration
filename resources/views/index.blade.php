@extends('layouts.app')

@prepend('html-scripts')
<script type="text/javascript" src="/bower_components/pwstrength-bootstrap/dist/pwstrength-bootstrap.min.js"></script>
@endprepend

@section('app-content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h4 class="text-center" id="page-header">
                    <img src="/resources/images/razi-logo.png" alt="" class="center-block">
                    <span>درگاه ثبت درخواست ایجاد ایمیل دانشجویان و اساتید دانشگاه رازی</span>
                </h4>
                <div class="panel with-nav-tabs panel-default">
                    <div class="panel-heading">
                        <ul class="nav nav-tabs nav-justified" id="tabs">
                            <li class="active"><a href="#tab1" data-toggle="tab">دانشجویان کارشناسی</a></li>
                            <li><a href="#tab2" data-toggle="tab">دانشجویان تحصیلات تکمیلی</a></li>
                            <li><a href="#tab3" data-toggle="tab">اساتید</a></li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-8 col-md-offset-2">
                                <div class="tab-content">
                                    <div class="tab-pane fade in active student-info" id="tab1">
                                        {!! BootForm::open(['data-domain' => ($domain = 'razi.ac.ir'), 'url' => route('request', $domain)]) !!}

                                        {!! BootForm::hidden('g-recaptcha-response') !!}

                                        {!! BootForm::text('name', 'نام و نام خانوادگی') !!}

                                        {!! BootForm::number('sid', 'شماره دانشجویی') !!}

                                        {!! BootForm::tel('tel', 'شماره همراه') !!}

                                        <div class="form-group{{ $errors->has('mail') ? ' has-error' : '' }}">
                                            <label for="mail" class="control-label">آدرس درخواستی</label>

                                            <div>
                                                <div class="input-group">
                                                    <span class="input-group-addon" dir="ltr">@razi.ac.ir</span>
                                                    {!! Form::text('mail', null, ['id' => 'mail','dir' => 'ltr', 'required', 'class' => 'form-control loading-right mail-check']) !!}
                                                    {{--<input id="mail" name="mail" type="text" dir="ltr" required--}}
                                                           {{--class="form-control loading-right mail-check"/>--}}
                                                </div>

                                                <span class="help-block">
                                                    @if ($errors->has('mail'))
                                                        <strong>{{ $errors->first('mail') }}</strong>
                                                    @endif
                                                </span>
                                            </div>
                                        </div>

                                        {!! BootForm::password('password', 'کلمه عبور', ['required']) !!}

                                        {!! BootForm::password('password_confirmation', 'تکرار کلمه عبور', ['required']) !!}

                                        {!! BootForm::checkbox('terms', new \Illuminate\Support\HtmlString('ضمن مطالعه دقیق '.'<a href="#">قوانین</a>'.' و '.'<a href="#">شرایط</a>'.'، با همه موارد موافقم')) !!}

                                        {!! BootForm::submit('ثبت درخواست') !!}

                                        {!! BootForm::close() !!}
                                    </div>
                                    <div class="tab-pane fade student-info" id="tab2">

                                    </div>
                                    <div class="tab-pane fade student-info" id="tab3">

                                    </div>
                                </div>
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
        var xhr = null, mailInput, mailInputGroup, mailHelper, tabs = null, reservedForm = null, c_token = null;

        $(function () {
            tabs = $('#tabs');

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

            $('#password').pwstrength({
                rules: {
                    activated: {
                        wordTwoCharacterClasses: true,
                        wordRepetitions: true
                    }
                },
                i18n: {
                    fa: {
                        "wordMinLength": "گذرواژه شما خیلی کوتاه است",
                        "wordMaxLength": "گذرواژه شما خیلی طولانی است",
                        "wordInvalidChar": "رمز عبور شما دارای یک کاراکتر نامعتبر است",
                        "wordNotEmail": "از ایمیل خود به عنوان رمز عبور خود استفاده نکنید",
                        "wordSimilarToUsername": "رمز عبور شما نمیتواند نام کاربری شما را داشته باشد",
                        "wordTwoCharacterClasses": "از انواع کاراکتر های مختلف استفاده کنید",
                        "wordRepetitions": "بیش از حد تکراری",
                        "wordSequences": "رمز عبور شما حاوی توالی است",
                        "errorList": "خطاها:",
                        "veryWeak": "خیلی ضعیف",
                        "weak": "ضعیف",
                        "normal": "طبیعی",
                        "medium": "متوسط",
                        "strong": "قوی",
                        "veryStrong": "بسیار قوی"
                    },
                    t: function (key) {
                        return this.fa[key];
                    }
                }
            });

            $('.mail-check').on('input', function () {
                mailInput = $(this);
                mailInputGroup = mailInput.parents('.form-group');
                mailHelper = mailInputGroup.find('.help-block');
                var text = mailInput.val();

                xhr === null || xhr.abort();
                if (text.length) {
                    mailInput.addClass('loading');
                    xhr = $.ajax({
                        method: 'get',
                        dataType: 'json',
                        url: '{{ route('validate_email', '__domain__') }}'.replace('__domain__', mailInputGroup.parents('form').attr('data-domain')),
                        data: {id: text},
                        complete: function () {
                            mailInput.removeClass('loading');
                        },
                        success: function (data) {
                            if (data.accepted) {
                                mailInput[0].setCustomValidity("");
                                mailInputGroup.removeClass('has-error');
                                mailInputGroup.addClass('has-success');
                                mailHelper.html('');
                            } else {
                                mailInput[0].setCustomValidity("ایمیل درخواستی معتبر نیست");
                                mailInputGroup.removeClass('has-success');
                                mailInputGroup.addClass('has-error');
                                mailHelper.html(data.message);
                            }
                        }
                    });
                } else {
                    mailInput.removeClass('loading');
                    mailInputGroup.removeClass('has-error');
                    mailHelper.html('');
                }
            })
        });

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
