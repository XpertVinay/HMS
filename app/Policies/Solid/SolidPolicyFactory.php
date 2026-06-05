<?php

namespace App\Policies\Solid;

use InvalidArgumentException;

/**
 * Class SolidPolicyFactory
 * 
 * Responsible for instantiating the correct policy based on the type string.
 */
class SolidPolicyFactory
{
    public static function create(string $type): SolidApprovalPolicyInterface
    {
        return match ($type) {
            'sale' => new SalePolicy(),
            'occupancy' => new OccupancyPolicy(),
            'lease' => new LeasePolicy(),
            'interior' => new InteriorPolicy(),
            'decoration' => new DecorationPolicy(),
            default => throw new InvalidArgumentException("Invalid SOLID approval type: {$type}"),
        };
    }
}
