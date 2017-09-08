<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicView extends Controller
{
    function index() {
        return view('index');
    }

    function validateUsername(Request $request, $domain) {
        $domain = "localdomain";

        $validate = validator(
            request()->only(['id']),
            [
                'id' => ['required','min:6','regex:/^[a-zA-Z0-9._-]+$/']
            ],
            ['regex' => ':attribute تنها میتواند شامل حروف و اعداد لاتین و نشانه های (- _ .) باشد.'],
            ['id' => 'آدرس درخواستی']
        );

        if ($validate->fails()) {
            return [
                'accepted' => false,
                'message' => '<ul>'.implode('',$validate->getMessageBag()->all('<li>:message</li>')).'</ul>',
            ];
        } else {
            $command = implode(" ", array_map(function($a){
                return '"'.addslashes($a).'"';
            }, [
                env("python.path"),
                app_path("Axigen/verify-email.py"),
                \request('id')."@".$domain,
                env("cli.user"),
                env("cli.pass"),
                env("cli.host").":".env("cli.port"),
            ]));

            exec($command, $dump, $response);

            if ($response == 2) {
                return [
                    'accepted' => true,
                ];
            } else {
                switch ($response) {
                    case 0:
                        $message = "آدرس درخواستی قبلا به ثبت رسیده است.";
                        break;
                    case 1:
                        $message = "نام دامنه نامعتبر است.";
                        break;
                    case 3:
                        $message = "خطا در برقراری ارتباط با سرور.";
                        break;
                    default:
                        $message = "خطای ناشناخته.";
                        break;
                }
                return [
                    'accepted' => false,
                    'message' => $message,
                ];
            }
        }
    }

    function recordRequest(Request $request, $domain) {
        switch ($domain) {
            case 'razi.ac.ir': {
                $this->validate($request, [
                    'name' => 'required',
                    'sid' => 'required|digits:9',
                    'tel' => 'required|digits:11|regex:/^09(\d)+/',
                    'password' => 'required|confirmed|min:4',
                    'terms' => 'accepted',
                ],[],[
                    'sid' => 'شماره دانشجویی',
                    'tel' => 'شماره همراه',
                ]);
                break;
            }
        }
    }
}
