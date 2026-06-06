<?php

namespace App\Policies\Solid;

use App\Models\Organization;

/**
 * Interface SolidApprovalPolicyInterface
 * 
 * Demonstrates SOLID Principles:
 * O - Open/Closed Principle: Open for extension (new approval types) but closed for modification.
 * D - Dependency Inversion: Service depends on this abstraction, not concrete implementations.
 */
interface SolidApprovalPolicyInterface
{
    /**
     * Get the charge amount for this approval type based on organization settings.
     *
     * @param Organization $organization
     * @return float
     */
    public function getChargeAmount(Organization $organization): float;

    /**
     * Get the descriptive name of the approval policy.
     *
     * @return string
     */
    public function getName(): string;
    
    /**
     * Determine if this approval type requires Staff (Stage 1) manual review.
     *
     * @return bool
     */
    public function requiresStaffReview(): bool;
}
