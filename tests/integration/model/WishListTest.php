<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class WishListTest extends TestCase
{

    use DatabaseTransactions;

    /** @test */
    function it_belongs_to_a_user(){
        $user = create_user();
        $list = $user->createWishList([
            'name'=>'my list'
        ]);
        $this->seeInDatabase('wish_lists',[
            'id'=>$list->id,
            'user_id'=>$user->id,
            'name'=>'my list'
        ]);
    }

    /** @test */
    function it_can_add_property_to_add_list(){
        $user = create_user();
        $list = $user->createWishList([
            'name'=>'my list'
        ]);
        $property = create_properties();

        $list->addItem($property);
        $this->seeInDatabase('wish_list_items',[
            'property_id'=>$property->id,
            'wish_list_id'=>$list->id,
        ]);

    }
}
