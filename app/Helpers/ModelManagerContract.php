<?php

namespace App\Helpers;

interface ModelManagerContract
{
    static function getModel();

    static function getPluralFa();
    static function getPluralEn();
    static function getSingularFa();
    static function getSingularEn();

    static function getViewDirectory();
}