<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;


class TenantScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        if(! Auth::hasUser()) {
            return;
        }
        $actor = Auth::user();

        if ($actor->hasRole('system_admin') &&
            method_exists($model, 'bypassTenantScopeForAdmin') &&
            $model->bypassTenantScopeForAdmin()
        ){
            return;
        }
        $builder->where($model->getTable().'.tenant_id', $actor->tenant_id);
    }
}

