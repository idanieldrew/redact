<?php

namespace Module\Panel\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Module\Panel\Jobs\CeremonyMessage;
use Module\Share\Contracts\Response\ResponseGenerator;

class AdminController extends Controller implements ResponseGenerator
{
    /**
     * Send message
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function ceremony(Request $request)
    {
        CeremonyMessage::dispatch($request->body);

        return $this->res('success', Response::HTTP_OK, 'successfully send');
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
