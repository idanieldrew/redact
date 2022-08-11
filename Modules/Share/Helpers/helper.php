<?php

function make_slug($string, $separator = '-')
{
    $string = trim($string);
    $string = mb_strtolower($string, 'UTF-8');
    $string = preg_replace("/[^a-z0-9_\-\sءاآؤئبپتثجچحخدذرزژسشصضطظعغفقكکگلمنوهی]/u", '', $string);
    $string = preg_replace("/[\s\-_]+/", ' ', $string);
    $string = preg_replace("/[\s_]/", $separator, $string);

    return $string;
}
