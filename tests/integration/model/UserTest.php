<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Collection;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    function it_has_roles()
    {
        $user = factory(\App\User::class)->create();
        $roles = $user->roles;
        $this->assertTrue($roles instanceof Collection);
    }

    /** @test */
    function it_has_method_can()
    {
        $user = factory(\App\User::class)->create();
        $result = $user->can('permission');
        $this->assertTrue(is_bool($result));
    }

    /** @test */
    function it_can_check_string()
    {
        $permission = \App\Permission::create([
            'label'=>'permission 1',
            'code'=>'permission_1'
        ]);
        $role = \App\Role::create([
            'label'=>'role 1',
            'code'=>'role_1'
        ]);
        $user = factory(\App\User::class)->create();

        $role->permissions()->save($permission);
        $user->roles()->save($role);

        $result1 = $user->can('permission_1');
        $result2 = $user->can('permission_2');

        $this->assertTrue($result1);
        $this->assertFalse($result2);

    }

    /** @test */
    function it_can_check_array()
    {
        $permission1 = \App\Permission::create([
            'label'=>'permission 1',
            'code'=>'permission_1'
        ]);
        $permission2 = \App\Permission::create([
            'label'=>'permission 2',
            'code'=>'permission_2'
        ]);
        $role1 = \App\Role::create([
            'label'=>'role 1',
            'code'=>'role_1'
        ]);
        $role2 = \App\Role::create([
            'label'=>'role 2',
            'code'=>'role_2'
        ]);
        $user = factory(\App\User::class)->create();

        $role1->permissions()->save($permission1);
        $role2->permissions()->save($permission2);
        $user->roles()->save($role1);
        $user->roles()->save($role2);

        $result3 = $user->can(['permission_1','permission_2']);
        $result4 = $user->can(['permission_3','permission_4']);

        $this->assertTrue($result3);
        $this->assertFalse($result4);
    }

    /** @test */
    function it_has_many_properties(){
        $user = factory(\App\User::class)->create();
        for($i=0; $i<3; $i++){
            create_properties($user);
        }
        $this->assertSame(3,$user->properties->count());
        $this->assertTrue($user->properties instanceof Collection);
    }

    /** @test */

    function it_has_media(){
        $user = create_user();
        $user->addMedia(['link' => 'user', 'type'=>'image']);
        $user->addMedia(['link' => 'user1', 'type'=>'image']);
        $user->addMedia(['link' => 'user2', 'type'=>'image']);
        $user->addMedia(['link' => 'user3', 'type'=>'image']);

        $this->seeInDatabase('media',[
           'owner_id'=>$user->id,
           'owner_type'=>get_class($user),
           'link'=>'user'
        ]);

        $this->assertEquals(4, $user->media->count());
    }
}
