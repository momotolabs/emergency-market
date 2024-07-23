<?php

namespace App\StorableEvents;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class ParkingDeployCreated extends ShouldBeStored
{
    public function __construct(
        public array $attributes,
    ) {
    }
}
