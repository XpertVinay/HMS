<?php

namespace App\Traits;

use App\Scopes\OrganizationScope;
use Illuminate\Database\Eloquent\Model;

trait TenantScoped
{
    /**
     * Boot the tenant scoped trait for a model.
     *
     * @return void
     */
    protected static function bootTenantScoped()
    {
        static::addGlobalScope(new OrganizationScope);

        // Automatically set the organization_id when creating new models
        static::creating(function (Model $model) {
            if (!$model->organization_id) {
                if (app()->has('active_org')) {
                    $model->organization_id = app()->make('active_org')->id;
                } elseif (session()->has('active_org_id')) {
                    $model->organization_id = session('active_org_id');
                }
            }
        });
    }
}
