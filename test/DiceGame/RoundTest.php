<?php

namespace Oenstrom\DiceGame;

/**
 * Test cases for class Round.
 */
class RoundTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test case to test making a roll.
     */
    public function testRoll()
    {
        $round = new Round();

        $this->assertFalse($round->roll(1));
        $this->assertTrue($round->roll(3));
    }


    /**
     * Test case to test removing all rolls made.
     */
    public function testEmptyRolls()
    {
        $round = new Round();

        $this->assertCount(0, $round->getRolls());

        $round->roll(3);
        $round->roll(5);

        $this->assertCount(2, $round->getRolls());

        $round->newRound();

        $this->assertCount(0, $round->getRolls());
    }


    /**
     * Test case to test the last roll made.
     */
    public function testGetLastRoll()
    {
        $round = new Round();

        $round->roll(3);
        $this->assertEquals(3, $round->getLastRoll());

        $round->roll(5);
        $this->assertEquals(5, $round->getLastRoll());

        $round->roll();
        $this->assertInternalType("integer", $round->getLastRoll());
    }


    /**
     * Test case to test the score of the current rolls.
     */
    public function testGetScore()
    {
        $round = new Round();

        $this->assertEquals(0, $round->getScore());

        $round->roll(3);
        $this->assertEquals(3, $round->getScore());

        $round->roll(6);
        $this->assertEquals(9, $round->getScore());

        $round->roll(2);
        $this->assertEquals(11, $round->getScore());

        $this->assertInternalType("integer", $round->getScore());
    }
}
