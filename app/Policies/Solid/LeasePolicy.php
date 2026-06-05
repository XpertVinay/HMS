<?php

namespace App\Policies\Solid;

use App\Models\Organization;

class LeasePolicy implements SolidApprovalPolicyInterface
{
    public function getChargeAmount(Organization $organization): float
    {
        return (float) $organization->solid_lease_charge;
    }

    public function getName(): string
    {
        return 'Lease Approval';
    }

    public function requiresStaffReview(): bool
    {
        return true;
    }
}
