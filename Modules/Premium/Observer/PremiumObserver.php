<?php

namespace Module\Premium\Observer;

use Illuminate\Support\Str;
use Module\Premium\Models\Premium;

class PremiumObserver
{
    public function creating(Premium $premium)
    {
        $premium->slug = Str::slug($premium->name);
    }
}
