<?php
/**
 * Author: Xavier Au
 * Date: 8/1/16
 * Time: 7:47 PM
 */

namespace App\Traits;


use App\Role;

trait PermissionRoleAuthenticationTrait
{
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
    public function can($checkingTerms, $arguments=[] ):bool
    {
        $permissions = is_string($checkingTerms)? [$checkingTerms]:$checkingTerms;
        $lists = [];
        $this->roles->map(function($role)use(&$lists){
            $lists = array_merge(array_diff($role->permissions()->lists('code')->toArray(), $lists), $lists);
        });

        return !! array_intersect($permissions, $lists);
    }
}