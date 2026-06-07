<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class OrganizationScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        // Verify the super_admin role against the database (cached per request)
        if (session('account') === 'super_admin') {
            static $isVerifiedSuperAdmin = null;
            if ($isVerifiedSuperAdmin === null) {
                $isVerifiedSuperAdmin = \App\Models\SuperAdmin::where('id', session('aid'))->exists();
            }
            if ($isVerifiedSuperAdmin) {
                return;
            }
        }

        // Check if there is an active organization bound to the container (resolved by middleware)
        if (app()->has('active_org')) {
            $orgId = app()->make('active_org')->id;
            $builder->where($model->getTable() . '.organization_id', $orgId);
            return;
        }

        // Fallback: check session for active org
        if (session()->has('active_org_id')) {
            $builder->where($model->getTable() . '.organization_id', session('active_org_id'));
        }
    }
}
