<?php

require_once('../../engine/Point.php');

class PointTest extends PHPUnit\Framework\TestCase
{

    public function testValidPoints()
    {
        $this->assertEquals(true, (new Point(0, 0))->isValid(10));
        $this->assertEquals(true, (new Point(5, 5))->isValid(10));
        $this->assertEquals(true, (new Point(9, 9))->isValid(10));
        $this->assertEquals(true, (new Point(0, 9))->isValid(10));
        $this->assertEquals(true, (new Point(9, 0))->isValid(10));
    }

    public function testInvalidPoints()
    {
        $this->assertEquals(false, (new Point(-1, 9))->isValid(10));
        $this->assertEquals(false, (new Point(9, -1))->isValid(10));
        $this->assertEquals(false, (new Point(11, 9))->isValid(10));
        $this->assertEquals(false, (new Point(9, 11))->isValid(10));
    }
}
