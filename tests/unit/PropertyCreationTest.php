<?php

use App\Permission;
use App\Role;
use App\Services\PropertyCreation;
use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PropertyCreationTest extends TestCase
{
    use DatabaseTransactions;
    /** @test */
    function it_has_owner_and_property_properties(){
        $creation = new PropertyCreation(create_user(), factory(\App\PropertyType::class)->create());
        $this->assertTrue(property_exists($creation, 'owner'));
        $this->assertTrue(property_exists($creation, 'propertyType'));
    }    /** @test */
    function it_has_create_method(){
        $creation = new PropertyCreation(create_user(), factory(\App\PropertyType::class)->create());
        $this->assertTrue(method_exists($creation, 'create'));
    }

    /** @test */
    function user_can_select_multiple_property_type_only_it_has_permission(){
        $permissionCode = 'multiple';
        $permission = factory(Permission::class)->create(['code'=>$permissionCode]);
        $isMultiplePropertyType = factory(\App\PropertyType::class)->create(['is_multiple'=>true]);
        $generalPropertyType = factory(\App\PropertyType::class)->create();
        $userHasPermission = create_user($permission);
        $userHasNoPermission = create_user();

        $param1 = [
            'name'=>'name1',
            'description'=>serialize(['code'=>'this is description'])
        ];
        $creation1 = new PropertyCreation($userHasPermission, $isMultiplePropertyType);
        $this->assertEquals('App\Property', get_class($creation1->create($param1)));
        $creation1 = new PropertyCreation($userHasPermission, $generalPropertyType);
        $this->assertEquals('App\Property', get_class($creation1->create($param1)));
        $creation1 = new PropertyCreation($userHasNoPermission, $generalPropertyType);
        $this->assertEquals('App\Property', get_class($creation1->create($param1)));

        $creation4 = new PropertyCreation($userHasNoPermission, $isMultiplePropertyType);
        $this->setExpectedException('App\Exceptions\UserCannotCreateMultipleTypePropertyException');
        $creation4->create($param1);
    }
}
