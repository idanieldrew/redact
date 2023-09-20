<?php

namespace Module\Auth\Http\Controllers\v2;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;
use Module\Auth\Http\Requests\v2\ChangePsdRequest;
use Module\Auth\Services\v2\AuthService;
use Module\Share\Contracts\Response\ResponseGenerator;

class ChangePsdController extends Controller implements ResponseGenerator
{
    /**
     * Change password operation
     *
     * @param ChangePsdRequest $request
     * @return JsonResponse
     */
    public function changPsd(ChangePsdRequest $request):JsonResponse
    {
        $result = (new AuthService)->changePsd($request);

        return $this->res($result['status'], $result['code'], $result['message'], $result['data']);
    }

    public function res(string $status, int $code, string|null $message, array|int|JsonResource $data = null): JsonResponse
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}
