<?php

namespace App\Policies\Solid;

use App\Models\Organization;

class SalePolicy implements SolidApprovalPolicyInterface
{
    public function getChargeAmount(Organization $organization): float
    {
        return (float) $organization->solid_sale_charge;
    }

    public function getName(): string
    {
        return 'Sale Approval';
    }

    public function requiresStaffReview(): bool
    {
        return true; // Sale requires careful review
    }
}
