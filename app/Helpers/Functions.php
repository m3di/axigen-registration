<?php

namespace App\Helpers;

function message_block($key = 'message', $class = 'alert') {
    return session($key) ? '<div class="'.("{$class} {$class}").'-'.session('message')[0].'">'.session('message')[1].'</div>' : '';
}
