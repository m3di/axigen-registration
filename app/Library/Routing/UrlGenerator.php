<?php

namespace App\Library\Routing;

class UrlGenerator extends \Illuminate\Routing\UrlGenerator {
    public function previous($fallback = false)
    {
        $referrer = $this->request->headers->get($this->request->ajax() ? 'X-Alt-Referer' : 'referer');

        if (! $referrer) {
            $referrer = $this->request->headers->get('referer');
        }

        $url = $referrer ? $this->to($referrer) : $this->getPreviousUrlFromSession();

        if ($url) {
            return $url;
        } elseif ($fallback) {
            return $this->to($fallback);
        } else {
            return $this->to('/');
        }
    }
}