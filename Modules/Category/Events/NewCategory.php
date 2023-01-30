<?php

namespace Module\Category\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewCategory
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $slug;

    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(string $slug)
    {
        $this->slug = $slug;
    }
}
