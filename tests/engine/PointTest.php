<?php

require_once('../../engine/Point.php');

class PointTest extends PHPUnit\Framework\TestCase
{

    public function testValidPoints()
    {
        $this->assertEquals(true, (new Point(0, 0))->isValid(10));
        $this->assertEquals(true, (new Point(5, 5))->isValid(10));
        $this->assertEquals(true, (new Point(10, 10))->isValid(10));
        $this->assertEquals(true, (new Point(0, 10))->isValid(10));
        $this->assertEquals(true, (new Point(10, 0))->isValid(10));
    }

    public function testInvalidPoints()
    {
        $this->assertEquals(false, (new Point(-1, 10))->isValid(10));
        $this->assertEquals(false, (new Point(10, -1))->isValid(10));
        $this->assertEquals(false, (new Point(11, 10))->isValid(10));
        $this->assertEquals(false, (new Point(10, 11))->isValid(10));
    }
}
