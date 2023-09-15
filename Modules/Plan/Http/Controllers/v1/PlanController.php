<?php

namespace Module\Plan\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Module\Plan\Http\Requests\v1\PlanRequest;
use Module\Plan\Models\Plan;
use Module\Plan\Services\v1\PlanService;
use Module\Share\Contracts\Response\ResponseGenerator;

class PlanController extends Controller implements ResponseGenerator
{
    protected function service()
    {
        return resolve(PlanService::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $service = $this->service()->index();

        return $this->res('success', 200, 'all plans', $service);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PlanRequest  $request
     * @return Response
     *
     * @throws AuthorizationException
     */
    public function store(PlanRequest $request)
    {
        $this->authorize('create', Plan::class);

        $service = $this->service()->store($request);

        return $this->res('success', 201, 'success create plan', $service);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
