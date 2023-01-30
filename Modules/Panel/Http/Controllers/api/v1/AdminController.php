<?php

namespace Module\Panel\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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

    public function res($status, $code, $message, $data = null)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}
