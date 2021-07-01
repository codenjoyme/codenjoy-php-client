<?php

require_once('../../../engine/Solver.php');
require_once('../../../engine/Board.php');
require_once('../../../engine/Point.php');
require_once('../../../games/mollymage/MollyMageSolver.php');
require_once('../../../games/mollymage/MollyMageBoard.php');
require_once('../../../games/mollymage/MollyMageElement.php');
require_once('../../../games/mollymage/MollyMageAction.php');

class MollyMageBoardTest extends PHPUnit\Framework\TestCase
{

    public function test_getAt_invalidPoint()
    {
        $board = new MollyMageBoard("###" . "###" . "###");
        $this->assertEquals(MollyMageElement::$elements['WALL'], $board->getAt(new Point(-1, -1)));
    }

    public function test_findHero()
    {
        $board = new MollyMageBoard("#☺#" . "###" . "###");
        $this->assertEquals(new Point(1, 2), $board->findHero());

        $board = new MollyMageBoard("###" . "#☻#" . "###");
        $this->assertEquals(new Point(1, 1), $board->findHero());

        $board = new MollyMageBoard("###" . "###" . "#Ѡ#");
        $this->assertEquals(new Point(1, 0), $board->findHero());

        $board = new MollyMageBoard("Ѡ☺☻" . "###" . "###");
        $this->assertEquals(new Point(0, 2), $board->findHero());
    }

    public function test_findHero_noResult()
    {
        $this->expectException(UnexpectedValueException::class);
        $board = new MollyMageBoard("###" . "###" . "###");
        $board->findHero();
    }

    public function test_isGameOver()
    {
        $board = new MollyMageBoard("###" . "##☺" . "###");
        $this->assertEquals(false, $board->isGameOver());

        $board = new MollyMageBoard("###" . "Ѡ##" . "###");
        $this->assertEquals(true, $board->isGameOver());
    }

    public function test_findOtherHeroes()
    {
        $board = new MollyMageBoard("#♥#" . "#♠#" . "#♣#");
        $this->assertEquals(
            array(new Point(1, 0), new Point(1, 1), new Point(1, 2)),
            $board->findOtherHeroes());
    }

    public function test_findBarriers()
    {
        $board = new MollyMageBoard("☼&#" . "123" . "♥♥♥");
        $this->assertEquals(
            array(new Point(0, 0), new Point(0, 1), new Point(0, 2),
                new Point(1, 0), new Point(1, 1), new Point(1, 2),
                new Point(2, 0), new Point(2, 1), new Point(2, 2)),
            $board->findBarriers());
    }

    public function test_walls()
    {
        $board = new MollyMageBoard("###" . "☼##" . "☼##");
        $this->assertEquals(
            array(new Point(0, 0), new Point(0, 1)),
            $board->findWalls());
    }

    public function test_ghosts()
    {
        $board = new MollyMageBoard("##&" . "##&" . "###");
        $this->assertEquals(
            array(new Point(2, 1), new Point(2, 2)),
            $board->findGhosts());
    }

    public function test_findTreasureBoxes()
    {
        $board = new MollyMageBoard("҉#҉" . "҉҉҉" . "҉#҉");
        $this->assertEquals(
            array(new Point(1, 0), new Point(1, 2)),
            $board->findTreasureBoxes());
    }

    public function test_findPotions()
    {
        $board = new MollyMageBoard("123" . "45#" . "☻♠#");
        $this->assertEquals(
            array(new Point(0, 0), new Point(0, 1), new Point(0, 2),
                new Point(1, 0), new Point(1, 1), new Point(1, 2), new Point(2, 2)),
            $board->findPotions());
    }

    public function test_findBlasts()
    {
        $board = new MollyMageBoard("###" . "###" . "##҉");
        $this->assertEquals(array(new Point(2, 0)), $board->findBlasts());
    }

    public function test_findPerks()
    {
        $board = new MollyMageBoard("#cr" . "#i+" . "###");
        $this->assertEquals(
            array(new Point(1, 1), new Point(1, 2),
                new Point(2, 1), new Point(2, 2)),
            $board->findPerks());

    }

    public function test_report()
    {
        $board = new MollyMageBoard("board=" .
            "☼☼☼☼☼☼☼☼☼" .
            "☼1 ♣   ♠☼" .
            "☼#2  &  ☼" .
            "☼# 3 ♣ ♠☼" .
            "☼☺  4   ☼" .
            "☼   ♥ H☻☼" .
            "☼x H ҉҉҉☼" .
            "☼& &    ☼" .
            "☼☼☼☼☼☼☼☼☼");
        $this->assertEquals("" .
            /*8*/ "☼☼☼☼☼☼☼☼☼\n" .
            /*7*/ "☼1 ♣   ♠☼\n" .
            /*6*/ "☼#2  &  ☼\n" .
            /*5*/ "☼# 3 ♣ ♠☼\n" .
            /*4*/ "☼☺  4   ☼\n" .
            /*3*/ "☼   ♥ H☻☼\n" .
            /*2*/ "☼x H ҉҉҉☼\n" .
            /*1*/ "☼& &    ☼\n" .
            /*0*/ "☼☼☼☼☼☼☼☼☼\n" .
            /*012345678*/
            "\n" .
            "Hero at: [1,4]\n" .
            "Other heroes at: [3,7][4,3][5,5][7,5][7,7]\n" .
            "Ghosts at: [1,1][3,1][5,6]\n" .
            "Potions at: [1,7][2,6][3,5][4,4][7,3][7,5][7,7]\n" .
            "Blasts at: [5,2][6,2][7,2]\n" .
            "Expected blasts at: ", $board->__toString());
    }
}
