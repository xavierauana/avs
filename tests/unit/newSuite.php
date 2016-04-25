<?php


class ExampleTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function this_is_a_test()
    {
        $var = true;
        $this->assertSame(true, $var);
    }
}
