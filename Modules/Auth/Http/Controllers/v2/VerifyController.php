<?php

namespace Module\Auth\Http\Controllers\v2;

use App\Http\Controllers\Controller;
use Module\Share\Contracts\Response\ResponseGenerator;
use Module\User\Models\User;

class VerifyController extends Controller implements ResponseGenerator
{
    public function verify(User $user)
    {
        $user->statuses()->update([
            'name' => 'verified',
            'reason' => 'verify complete',
        ]);

        return $this->res('success', 200, 'successfully verify');
    }

    public function res($status, $code, $message, $data = null)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}
