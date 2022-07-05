<?php

namespace Module\Tag\Services\v1;

use Module\Tag\Models\Tag;
use Module\Tag\Services\TagService as Service;

class TagService extends Service
{
    /**
     * Create new tag
     * @param $request
     * @return array
     */
    public function store($request): array
    {
        foreach ($request as $tags) {
            $this->model()->firstWhere('name', '=', $tags) ??
                $this->model()->create([
                    'name' => $tags
                ]);
        }

        return $this->model()
            ->whereIn('name', $request)
            ->get()
            ->pluck('id')
            ->toArray();
    }
}
