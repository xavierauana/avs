<?php

use App\Property;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PropertiesTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    function it_always_true(){
        $this->assertTrue(true);
    }
}
