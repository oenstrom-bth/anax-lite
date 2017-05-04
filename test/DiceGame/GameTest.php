<?php

namespace Oenstrom\DiceGame;

/**
 * Test cases for class Game.
 */
class GameTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test case to test creating a new Game object with different amount of players.
     */
    public function testCreateObject()
    {
        $game = new Game();
        $this->assertInstanceOf("\Oenstrom\DiceGame\Game", $game);
        $this->assertEquals(
            [["name" => "Spelare 1", "score" => 0], ["name" => "Spelare 2", "score" => 0]],
            $game->getPlayerList()
        );

        $game = new Game(4);
        $this->assertInstanceOf("\Oenstrom\DiceGame\Game", $game);
        $this->assertEquals(
            [
                ["name" => "Spelare 1", "score" => 0],
                ["name" => "Spelare 2", "score" => 0],
                ["name" => "Spelare 3", "score" => 0],
                ["name" => "Spelare 4", "score" => 0],
            ],
            $game->getPlayerList()
        );
    }


    /**
     * Test case to test if there is a winner in the game.
     */
    public function testHasWinner()
    {
        $game = new Game();

        $this->assertFalse($game->hasWinner());

        $game->handle("roll", 105);
        $game->handle("save");

        $this->assertTrue($game->hasWinner());

        $game->handle("reset");

        $this->assertFalse($game->hasWinner());
    }


    /**
     * Test case to test last roll made.
     */
    public function testGetLastRoll()
    {
        $game = new Game();

        $game->handle("roll", 3);

        $this->assertEquals(3, $game->getLastRoll());
    }


    /**
     * Test case to test the rolls made.
     */
    public function testGetRolls()
    {
        $game = new Game();

        $game->handle("roll", 3);
        $game->handle("roll", 6);
        $game->handle("roll", 2);

        $this->assertEquals("3, 6, 2", $game->getRolls());
    }


    /**
     * Test case to test the current score of the rolls.
     */
    public function testGetCurrentScore()
    {
        $game = new Game();

        $game->handle("roll", 3);
        $this->assertEquals(3, $game->getCurrentScore());

        $game->handle("roll", 6);
        $this->assertEquals(9, $game->getCurrentScore());

        $game->handle("roll", 2);
        $this->assertEquals(11, $game->getCurrentScore());
    }


    /**
     * Test case to test who the current player is.
     */
    public function testGetPlayer()
    {
        $game = new Game();
        $this->assertEquals("Spelare 1", $game->getPlayer());
    }
}
