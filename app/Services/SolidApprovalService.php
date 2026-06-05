<?php

namespace App\Services;

use App\Models\Member;
use App\Models\Organization;
use App\Models\SolidApproval;
use App\Models\Maintenance;
use App\Models\MaintenanceItem;
use App\Policies\Solid\SolidPolicyFactory;
use Illuminate\Support\Facades\DB;
use Exception;

class SolidApprovalService
{
    /**
     * Submit a new SOLID approval request and generate the associated charge invoice.
     *
     * @param Member $member
     * @param string $type
     * @param string $description
     * @param string|null $documentPath
     * @return SolidApproval
     * @throws Exception
     */
    public function submitRequest(Member $member, string $type, string $description, ?string $documentPath = null): SolidApproval
    {
        DB::beginTransaction();

        try {
            $organization = $member->organization;
            
            // Instantiate policy using the factory
            $policy = SolidPolicyFactory::create($type);
            
            // Get charge amount from the policy
            $chargeAmount = $policy->getChargeAmount($organization);
            
            // Determine initial status based on policy
            $initialStatus = $policy->requiresStaffReview() ? 'pending_staff' : 'pending_admin';

            $maintenanceId = null;

            // Generate an invoice if there is a charge
            if ($chargeAmount > 0) {
                $maintenance = Maintenance::create([
                    'organization_id' => $organization->id,
                    'member_id' => $member->id,
                    'billing_date' => now(),
                    'status' => 0, // Unpaid
                    'total_amount' => $chargeAmount,
                    'amount_payed' => 0,
                    'amount_change' => 0,
                    'invoice' => 'SOLID-' . strtoupper($type) . '-' . time(),
                ]);

                MaintenanceItem::create([
                    'maintenance_id' => $maintenance->id,
                    'item' => $policy->getName() . ' Processing Fee',
                    'amount' => $chargeAmount,
                ]);

                $maintenanceId = $maintenance->id;
            }

            // Create the approval request
            $approval = SolidApproval::create([
                'organization_id' => $organization->id,
                'member_id' => $member->id,
                'approval_type' => $type,
                'status' => $initialStatus,
                'description' => $description,
                'charge_amount' => $chargeAmount,
                'maintenance_id' => $maintenanceId,
                'document_path' => $documentPath,
            ]);

            DB::commit();
            
            return $approval;

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
