<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Get the active organization from the container.
     */
    protected function activeOrg()
    {
        return app('active_org');
    }

    /**
     * Get the active organization ID.
     */
    protected function orgId(): int
    {
        if (session('account') === 'super_admin' && session()->has('managed_org_id')) {
            return session('managed_org_id');
        }

        return $this->activeOrg()->id;
    }
}
