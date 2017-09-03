<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicView extends Controller
{
    function index() {
        return view('index');
    }

    function validateUsername() {
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
            return [
                'accepted' => true,
            ];
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
