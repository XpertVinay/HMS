<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Spatie\Permission\Models\Role;

class MigrateUsersToUnifiedSystem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hms:migrate-users {--rollback : Revert the migration and clear the unified tables} {--force : Force the operation to run without confirmation prompts}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate users from legacy separate tables into the unified users table with Spatie Roles.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->option('rollback')) {
            $this->rollback();
            return;
        }

        if (!$this->option('force') && !$this->confirm('This will truncate the users and roles tables and re-import from legacy tables. Proceed?')) {
            return;
        }

        try {
            $this->info('Cleaning up existing unified data...');
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            DB::table('model_has_roles')->truncate();
            DB::table('roles')->truncate();
            DB::table('users')->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            $this->migrateSuperAdmins();
            $this->migrateAdmins();
            $this->migrateStaff();
            $this->migrateMembers();
            $this->migrateResidents();
            $this->migrateVendors();

            $this->info('User migration completed successfully!');
        } catch (\Exception $e) {
            $this->error('Migration failed: ' . $e->getMessage());
        }
    }

    protected function rollback()
    {
        if (!$this->confirm('Are you sure you want to rollback? This will clear ALL data in users and roles tables.')) {
            return;
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('model_has_roles')->truncate();
        DB::table('roles')->truncate();
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->info('Rollback complete. Unified tables are now empty.');
    }

    private function getOrCreateRole($roleName, $orgId = null)
    {
        // For Spatie Permission with teams (organization_id)
        setPermissionsTeamId($orgId);
        
        $role = Role::where('name', $roleName)->where('organization_id', $orgId)->first();
        if (!$role) {
            $role = Role::create([
                'name' => $roleName,
                'organization_id' => $orgId,
                'guard_name' => 'web'
            ]);
        }
        return $role;
    }

    private function migrateSuperAdmins()
    {
        $this->info('Migrating super_admins...');
        $records = DB::table('super_admin')->get();
        foreach ($records as $record) {
            $user = User::create([
                'name' => $record->username,
                'username' => $record->username,
                'email' => $record->email,
                'password' => $record->password,
                'organization_id' => null,
                'is_verified' => true,
                'user_meta' => ['legacy_type' => 'super_admin', 'legacy_id' => $record->id]
            ]);

            $role = $this->getOrCreateRole('super_admin', null);
            $user->assignRole($role);
        }
    }

    private function migrateAdmins()
    {
        $this->info('Migrating admins...');
        $records = DB::table('admin')->get();
        foreach ($records as $record) {
            $user = User::create([
                'name' => $record->username,
                'username' => $record->username,
                'email' => $record->email,
                'password' => $record->password,
                'organization_id' => $record->organization_id,
                'mobile_number' => $record->mobile_number,
                'is_verified' => $record->is_id_verified,
                'user_meta' => [
                    'legacy_type' => 'admin', 
                    'legacy_id' => $record->id,
                    'role_type' => $record->role, // admin or sub-admin
                    'rwa_election_copy' => $record->rwa_election_copy,
                    'social_registration_number' => $record->social_registration_number
                ]
            ]);

            $role = $this->getOrCreateRole($record->role ?? 'admin', $record->organization_id);
            setPermissionsTeamId($record->organization_id);
            $user->assignRole($role);
        }
    }

    private function migrateStaff()
    {
        $this->info('Migrating staff...');
        $records = DB::table('staff')->get();
        foreach ($records as $record) {
            $user = User::create([
                'name' => $record->username,
                'username' => $record->username,
                'email' => $record->email,
                'password' => $record->password,
                'organization_id' => $record->organization_id,
                'mobile_number' => $record->mobile_number,
                'is_verified' => $record->is_id_verified,
                'user_meta' => [
                    'legacy_type' => 'staff', 
                    'legacy_id' => $record->id,
                    'employment_contract' => $record->employment_contract
                ]
            ]);

            $role = $this->getOrCreateRole('staff', $record->organization_id);
            setPermissionsTeamId($record->organization_id);
            $user->assignRole($role);
        }
    }

    private function migrateMembers()
    {
        $this->info('Migrating members...');
        $records = DB::table('member')->get();
        foreach ($records as $record) {
            $user = User::create([
                'name' => $record->username,
                'username' => $record->username,
                'email' => $record->email,
                'password' => $record->password,
                'organization_id' => $record->organization_id,
                'mobile_number' => $record->phone,
                'address' => $record->address,
                'is_verified' => $record->is_deed_verified_admin,
                'user_meta' => [
                    'legacy_type' => 'member', 
                    'legacy_id' => $record->id,
                    'share_certificate' => $record->share_certificate,
                    'is_deed_verified_staff' => $record->is_deed_verified_staff
                ]
            ]);

            $role = $this->getOrCreateRole('member', $record->organization_id);
            setPermissionsTeamId($record->organization_id);
            $user->assignRole($role);
        }
    }

    private function migrateResidents()
    {
        $this->info('Migrating residents...');
        $records = DB::table('resident')->get();
        foreach ($records as $record) {
            $user = User::create([
                'name' => $record->username,
                'username' => $record->username,
                'email' => $record->email,
                'password' => $record->password,
                'organization_id' => $record->organization_id,
                'mobile_number' => $record->mobile_number,
                'address' => $record->address,
                'is_verified' => $record->is_rent_agreement_verified_admin,
                'user_meta' => [
                    'legacy_type' => 'resident', 
                    'legacy_id' => $record->id,
                    'owner_noc' => $record->owner_noc,
                    'is_rent_agreement_verified_staff' => $record->is_rent_agreement_verified_staff
                ]
            ]);

            $role = $this->getOrCreateRole('resident', $record->organization_id);
            setPermissionsTeamId($record->organization_id);
            $user->assignRole($role);
        }
    }

    private function migrateVendors()
    {
        $this->info('Migrating vendors...');
        $records = DB::table('vendor')->get();
        foreach ($records as $record) {
            $user = User::create([
                'name' => $record->business_name,
                'email' => $record->email,
                'password' => $record->password,
                'organization_id' => null, // Vendors are global
                'is_verified' => $record->is_gst_verified_admin,
                'user_meta' => [
                    'legacy_type' => 'vendor', 
                    'legacy_id' => $record->id,
                    'business_registration' => $record->business_registration,
                    'bank_account_details' => $record->bank_account_details,
                    'is_gst_verified_staff' => $record->is_gst_verified_staff
                ]
            ]);

            $role = $this->getOrCreateRole('vendor', null);
            setPermissionsTeamId(null);
            $user->assignRole($role);
        }
    }
}
