<?php
/**
 * Author: Xavier Au
 * Date: 11/1/16
 * Time: 1:20 PM
 */

namespace App\Services;


use App\Exceptions\UserCannotCreateMultipleTypePropertyException;
use App\Property;
use App\PropertyType;
use App\User;

class PropertyCreation
{
    protected $owner;
    protected $propertyType;

    /**
     * PropertyCreation constructor.
     * @param $owner
     * @param $propertyType
     */
    public function __construct(User $owner,PropertyType $propertyType)
    {
        $this->owner = $owner;
        $this->propertyType = $propertyType;
    }


    public function create(array $param): Property
    {
        if($this->userCanCreatePropertyWithSpecificPropertyType()){
            $param = array_merge($param, ['property_type_id'=>$this->propertyType->id]);
            $property = $this->owner->properties()->create($param);
            return $property;
        }
        throw new UserCannotCreateMultipleTypePropertyException;
    }

    private function userCanCreatePropertyWithSpecificPropertyType():bool
    {
        return $this->propertyType->is_multiple? $this->owner->can('multiple'): true;
    }


}