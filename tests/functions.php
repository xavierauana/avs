<?php
use App\Permission;
use App\Property;
use App\PropertyType;
use App\Role;
use App\User;

function create_properties(User $user=null, PropertyType $propertyType=null, bool $is_multiple=false): Property{
    $user = $user?? factory(User::class)->create();
    $propertyType = $propertyType?? factory(PropertyType::class)->create(['is_multiple'=>$is_multiple]);
    $property = factory(Property::class)->create([
        'property_type_id' => $propertyType->id,
        'owner_id' => $user->id,
    ]);

    return $property;
}

/**
 * @param \App\Permission $permission
 * @param Role       $role
 */
function create_user(Permission $permission=null, Role $role=null):User{
    $permission = $permission ?? factory(Permission::class)->create();
    $role = $role ?? factory(Role::class)->create();
    $role->permissions()->save($permission);
    $user = factory(User::class)->create();
    $user->roles()->save($role);
    return $user;
};
