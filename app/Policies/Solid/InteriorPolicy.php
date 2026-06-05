<?php

namespace App\Policies\Solid;

use App\Models\Organization;

class InteriorPolicy implements SolidApprovalPolicyInterface
{
    public function getChargeAmount(Organization $organization): float
    {
        return (float) $organization->solid_interior_charge;
    }

    public function getName(): string
    {
        return 'Interior Work Approval';
    }

    public function requiresStaffReview(): bool
    {
        return true;
    }
}
