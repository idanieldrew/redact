<?php

namespace Module\Share\Contracts\Response;

use Illuminate\Http\Resources\Json\JsonResource;

interface ResponseGenerator
{
    public function res(string $status, int $code, string|null $message, array|int|JsonResource $data = null);
}
