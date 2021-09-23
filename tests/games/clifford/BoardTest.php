<?php

use DetectiveClifford\Board;
use DetectiveClifford\Element;

require_once('../../../engine/GameSolver.php');
require_once('../../../engine/GameBoard.php');
require_once('../../../engine/Point.php');
require_once('../../../games/clifford/Solver.php');
require_once('../../../games/clifford/Board.php');
require_once('../../../games/clifford/Element.php');

class BoardTest extends PHPUnit\Framework\TestCase
{

    public function test_isGameOver()
    {
        $board = new Board("###" . "##►" . "###");
        $this->assertEquals(false, $board->isGameOver());

        $board = new Board("###" . "Ѡ##" . "###");
        $this->assertEquals(true, $board->isGameOver());
        $board = new Board("###" . "x##" . "###");
        $this->assertEquals(true, $board->isGameOver());
    }

    public function test_findHero()
    {
        $board = new Board("Ѡ##" . "###" . "###");
        $this->assertEquals(new Point(0, 2), $board->findHero());
        $board = new Board("#Я#" . "###" . "###");
        $this->assertEquals(new Point(1, 2), $board->findHero());
        $board = new Board("##R" . "###" . "###");
        $this->assertEquals(new Point(2, 2), $board->findHero());
        $board = new Board("###" . "Y##" . "###");
        $this->assertEquals(new Point(0, 1), $board->findHero());
        $board = new Board("###" . "#◄#" . "###");
        $this->assertEquals(new Point(1, 1), $board->findHero());
        $board = new Board("###" . "##►" . "###");
        $this->assertEquals(new Point(2, 1), $board->findHero());
        $board = new Board("###" . "###" . "]##");
        $this->assertEquals(new Point(0, 0), $board->findHero());
        $board = new Board("###" . "###" . "#[#");
        $this->assertEquals(new Point(1, 0), $board->findHero());
        $board = new Board("###" . "###" . "##{");
        $this->assertEquals(new Point(2, 0), $board->findHero());
        $board = new Board("###" . "###" . "##}");
        $this->assertEquals(new Point(2, 0), $board->findHero());
        $board = new Board("###" . "###" . "##⍃");
        $this->assertEquals(new Point(2, 0), $board->findHero());
        $board = new Board("###" . "###" . "##⍄");
        $this->assertEquals(new Point(2, 0), $board->findHero());

        $board = new Board("⍃⍄ѠЯ" . "RY◄►" . "][{}" . "####");
        $this->assertEquals(new Point(0, 1), $board->findHero());
    }

    public function test_findMaskHero()
    {
        $board = new Board("x##" . "###" . "###");
        $this->assertEquals(new Point(0, 2), $board->findHero());
        $board = new Board("#⊰#" . "###" . "###");
        $this->assertEquals(new Point(1, 2), $board->findHero());
        $board = new Board("##⊱" . "###" . "###");
        $this->assertEquals(new Point(2, 2), $board->findHero());
        $board = new Board("###" . "⍬##" . "###");
        $this->assertEquals(new Point(0, 1), $board->findHero());
        $board = new Board("###" . "#⊲#" . "###");
        $this->assertEquals(new Point(1, 1), $board->findHero());
        $board = new Board("###" . "##⊳" . "###");
        $this->assertEquals(new Point(2, 1), $board->findHero());
        $board = new Board("###" . "###" . "⊅##");
        $this->assertEquals(new Point(0, 0), $board->findHero());
        $board = new Board("###" . "###" . "#⊄#");
        $this->assertEquals(new Point(1, 0), $board->findHero());
        $board = new Board("###" . "###" . "##⋜");
        $this->assertEquals(new Point(2, 0), $board->findHero());
        $board = new Board("###" . "###" . "##⋝");
        $this->assertEquals(new Point(2, 0), $board->findHero());
        $board = new Board("###" . "###" . "##ᐊ");
        $this->assertEquals(new Point(2, 0), $board->findHero());
        $board = new Board("###" . "###" . "##ᐅ");
        $this->assertEquals(new Point(2, 0), $board->findHero());

        $board = new Board("ᐊᐅx⊰" . "⊱⍬⊲⊳" . "⊅⊄⋜⋝" . "####");
        $this->assertEquals(new Point(0, 1), $board->findHero());
    }

    public function test_findHero_noResult()
    {
        $this->expectException(UnexpectedValueException::class);
        $board = new Board("###" . "###" . "###");
        $board->findHero();
    }

    public function test_findOtherHeroes()
    {
        $board = new Board("##Z⌋" . "⌊U)(" . "⊐⊏ЭЄ" . "ᗉᗆ##");
        $this->assertEquals([new Point(0, 0), new Point(0, 1), new Point(0, 2),
            new Point(1, 0), new Point(1, 1), new Point(1, 2), new Point(2, 1),
            new Point(2, 2), new Point(2, 3), new Point(3, 1), new Point(3, 2),
            new Point(3, 3)], $board->findOtherHeroes());

        $board = new Board("##⋈⋰" . "⋱⋕⋊⋉" . "⋣⋢⊣⊢" . "ᗏᗌ##");
        $this->assertEquals([new Point(0, 0), new Point(0, 1), new Point(0, 2),
            new Point(1, 0), new Point(1, 1), new Point(1, 2), new Point(2, 1),
            new Point(2, 2), new Point(2, 3), new Point(3, 1), new Point(3, 2),
            new Point(3, 3)], $board->findOtherHeroes());
    }

    public function test_findEnemyHeroes()
    {
        $board = new Board("##Ž⟧" . "⟦Ǔ❫❪" . "⋥⋤ǮĚ" . "⇇⇉##");
        $this->assertEquals([new Point(0, 0), new Point(0, 1), new Point(0, 2),
            new Point(1, 0), new Point(1, 1), new Point(1, 2), new Point(2, 1),
            new Point(2, 2), new Point(2, 3), new Point(3, 1), new Point(3, 2),
            new Point(3, 3)], $board->findEnemyHeroes());

        $board = new Board("##⧓⇢" . "⇠≠⧒⧑" . "⌫⌦❵❴" . "⬱⇶##");
        $this->assertEquals([new Point(0, 0), new Point(0, 1), new Point(0, 2),
            new Point(1, 0), new Point(1, 1), new Point(1, 2), new Point(2, 1),
            new Point(2, 2), new Point(2, 3), new Point(3, 1), new Point(3, 2),
            new Point(3, 3)], $board->findEnemyHeroes());
    }

    public function test_findRobbers()
    {
        $board = new Board("Q«»" . "‹›<" . ">⍇⍈");
        $this->assertEquals([new Point(0, 0), new Point(0, 1), new Point(0, 2),
            new Point(1, 0), new Point(1, 1), new Point(1, 2), new Point(2, 0),
            new Point(2, 1), new Point(2, 2)], $board->findRobbers());
    }

    public function test_findBarriers()
    {
        $board = new Board("  #" . "  ☼" . "   ");
        $this->assertEquals(array(new Point(2, 1), new Point(2, 2)), $board->findBarriers());
    }

    public function test_findPits()
    {
        $board = new Board("123" . "4**" . "###");
        $this->assertEquals([new Point(0, 1), new Point(0, 2), new Point(1, 1),
            new Point(1, 2), new Point(2, 1), new Point(2, 2)], $board->findPits());
    }

    public function test_findClues()
    {
        $board = new Board("##$" . "##&" . "##@");
        $this->assertEquals(array(new Point(2, 0), new Point(2, 1), new Point(2, 2)), $board->findClues());
    }

    public function test_findBackways()
    {
        $board = new Board("##⊛" . "###" . "###");
        $this->assertEquals(array(new Point(2, 2)), $board->findBackways());
    }

    public function test_findPotions()
    {
        $board = new Board("##S" . "###" . "###");
        $this->assertEquals(array(new Point(2, 2)), $board->findPotions());
    }

    public function test_findDoors()
    {
        $board = new Board("⍙⍚⍜" . "⍍⌺⌼" . "###");
        $this->assertEquals([new Point(0, 1), new Point(0, 2), new Point(1, 1),
            new Point(1, 2), new Point(2, 1), new Point(2, 2)], $board->findDoors());
    }

    public function test_findKeys()
    {
        $board = new Board("✦✼⍟" . "###" . "###");
        $this->assertEquals([new Point(0, 2), new Point(1, 2), new Point(2, 2)], $board->findKeys());
    }

    public function test_report()
    {
        $board = new Board("board=" .
            "☼☼☼☼☼☼☼☼☼" .
            "☼ ►*## \$☼" .
            "☼ H ⧒⧒ ✼☼" .
            "☼ H  1 ⍍☼" .
            "☼S ⊐ &  ☼" .
            "☼ ✦ ~~~ ☼" .
            "☼Z3 ⌺ ⊏ ☼" .
            "☼ @@ ⍈Q ☼" .
            "☼☼☼☼☼☼☼☼☼");
        $this->assertEquals("" .
            "☼☼☼☼☼☼☼☼☼\n" .
            "☼ ►*## \$☼\n" .
            "☼ H ⧒⧒ ✼☼\n" .
            "☼ H  1 ⍍☼\n" .
            "☼S ⊐ &  ☼\n" .
            "☼ ✦ ~~~ ☼\n" .
            "☼Z3 ⌺ ⊏ ☼\n" .
            "☼ @@ ⍈Q ☼\n" .
            "☼☼☼☼☼☼☼☼☼\n" .
            "\n" .
            "Hero at: [2,7]\n" .
            "Other heroes at: [1,2][3,4][6,2]\n" .
            "Enemy heroes at: [4,6][5,6]\n" .
            "Robbers at: [5,1][6,1]\n" .
            "Mask potions at: [1,4]\n" .
            "Keys at: [2,3][7,6]", $board->__toString());
    }
}
