<?php

namespace Oenstrom\DiceGame;

class Dice
{
    private static $faces = 6;
    private $rolls = [];
    private $lastRoll = null;


    /**
     * Roll the dice.
     *
     * @return int as the roll;
     */
    public function roll()
    {
        $roll = rand(1, self::$faces);
        $this->rolls[] = $roll;
        $this->lastRoll = $roll;
        return $roll;
    }


    public function emptyRolls()
    {
        $this->rolls = [];
    }


    /**
     * Get the array of rolls.
     *
     * @return array as the list of rolls.
     */
    public function getRolls()
    {
        return $this->rolls;
    }


    /**
     * Get the last of roll made.
     *
     * @return int as the roll.
     */
    public function getLastRoll()
    {
        return $this->lastRoll;
    }


    /**
     * Get total value from the rolls.
     *
     * @return int as sum of rolls.
     */
    public function getTotal()
    {
        return array_sum($this->rolls);
    }
}
