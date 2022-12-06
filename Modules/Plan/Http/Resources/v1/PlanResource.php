<?php

namespace Module\Plan\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class PlanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'slug' => $request->slug,
            'count_account' => $request->count_account,
            'description' => $request->description,
            'price' => $request->price,
            'period' => $request->period,
            'interval' => $request->interval,
            'features' => new PlanFeatureResource($this->plan_feature)
        ];
    }
}
