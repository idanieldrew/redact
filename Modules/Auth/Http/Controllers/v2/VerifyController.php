<?php

namespace Module\Auth\Http\Controllers\v2;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Module\Auth\Services\v2\AuthService;
use Module\Share\Contracts\Response\ResponseGenerator;
use Module\User\Models\User;

class VerifyController extends Controller implements ResponseGenerator
{
    public function verify(User $user, AuthService $service)
    {
        $data = [
            'name' => 'verified',
            'reason' => 'verify complete',
        ];
        $res = $service->verifyHandler($user, $data);

        return $this->res(
            'success',
            200,
            'successfully verify',
            $res
        );
    }

    public function res(string $status, int $code, string|null $message, mixed $data = null): JsonResponse
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}
