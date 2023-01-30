<?php

namespace Module\Plan\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class PlanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'count_account' => $this->count_account,
            'description' => $this->description,
            'price' => $this->price,
            'period' => $this->period,
            'interval' => $this->interval,
            'features' => $this->whenLoaded('plan_feature', function () {
                return new PlanFeatureResource($this->plan_feature);
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
