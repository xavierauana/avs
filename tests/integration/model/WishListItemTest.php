<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class WishListItemTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    function it_can_add_note_to_each_wish_list_item(){
        $user = create_user();
        $list = $user->createWishList(['name'=>'my wish list']);
        $item = $list->addItem(create_properties());
        $myNote = "My own description.";
        $item->note = $myNote;
        $item->save();

        $this->seeInDatabase('wish_list_items', [
            'wish_list_id'=>$list->id,
            'id'=>$item->id,
            'note'=>$myNote
        ]);

    }
}
