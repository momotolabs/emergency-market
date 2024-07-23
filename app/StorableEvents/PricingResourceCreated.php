<?php

namespace App\StorableEvents;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class PricingResourceCreated extends ShouldBeStored
{
    public function __construct(
        public array $attributes,
    ) {
    }
}
