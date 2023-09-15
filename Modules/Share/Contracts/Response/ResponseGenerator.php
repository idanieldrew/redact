<?php

namespace Module\Share\Contracts\Response;

interface ResponseGenerator
{
    public function res(string $status, int $code, string|null $message, mixed $data = null);
}
