<?php

namespace App\StorableEvents;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class PricingResourceUpdated extends ShouldBeStored
{
    public function __construct(
        public array $attributes,
    ) {
    }
}
