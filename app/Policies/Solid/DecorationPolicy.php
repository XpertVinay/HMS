<?php

namespace App\Policies\Solid;

use App\Models\Organization;

class DecorationPolicy implements SolidApprovalPolicyInterface
{
    public function getChargeAmount(Organization $organization): float
    {
        return (float) $organization->solid_decoration_charge;
    }

    public function getName(): string
    {
        return 'Decoration Approval';
    }

    public function requiresStaffReview(): bool
    {
        return false; // Decorations might only require Admin auto-approval or straight to Admin
    }
}
