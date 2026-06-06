<?php

namespace App\Policies\Solid;

use App\Models\Organization;

class OccupancyPolicy implements SolidApprovalPolicyInterface
{
    public function getChargeAmount(Organization $organization): float
    {
        return (float) $organization->solid_occupancy_charge;
    }

    public function getName(): string
    {
        return 'Occupancy Approval';
    }

    public function requiresStaffReview(): bool
    {
        return true;
    }
}
