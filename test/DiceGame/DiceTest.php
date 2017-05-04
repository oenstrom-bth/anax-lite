<?php

namespace Oenstrom\DiceGame;

/**
 * Test cases for class Dice.
 */
class DiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test case to test making a roll;
     */
    public function testRoll()
    {
        $dice = new Dice();

        $this->assertInternalType("integer", $dice->roll());
        $this->assertGreaterThanOrEqual(1, $dice->roll());
        $this->assertLessThanOrEqual(6, $dice->roll());
    }


    /**
     * Test case to test rolls made.
     */
    public function testGetRolls()
    {
        $dice = new Dice();
        $dice->roll();
        $dice->roll();

        $this->assertInternalType("array", $dice->getRolls());
        $this->assertCount(2, $dice->getRolls());

        $this->assertInternalType("integer", $dice->getRolls()[0]);
        $this->assertInternalType("integer", $dice->getRolls()[1]);

        $dice->emptyRolls();
        $this->assertCount(0, $dice->getRolls());

    }


    /**
     * Test case to test the last roll made.
     */
    public function testGetLastRoll()
    {
        $dice = new Dice();
        $dice->roll();

        $this->assertInternalType("integer", $dice->getLastRoll());
        $this->assertGreaterThanOrEqual(1, $dice->getLastRoll());
        $this->assertLessThanOrEqual(6, $dice->getLastRoll());
    }


    /**
     * Test case to test the total value of the rolls.
     */
    public function testGetTotal()
    {
        $dice = new Dice();
        $dice->roll();
        $dice->roll();

        $this->assertInternalType("integer", $dice->getTotal());
        $this->assertEquals(array_sum($dice->getRolls()), $dice->getTotal());
    }
}
