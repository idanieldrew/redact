<?php

namespace Module\Share\Contracts\Response;

interface ResponseGenerator
{
    public function res($success,$status,$message,$data);
}