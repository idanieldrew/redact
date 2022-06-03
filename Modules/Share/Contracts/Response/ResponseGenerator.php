<?php

namespace Module\Share\Contracts\Response;

interface ResponseGenerator
{
    public function res($status, $code, $message, $data);
}