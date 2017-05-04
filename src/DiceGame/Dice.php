<?php

namespace Oenstrom\DiceGame;

/**
 * Class representing a dice.
 */
class Dice
{
    /**
     * @var integer $faces the number of faces of the dice.
     * @var array $rolls the rolls made.
     * @var integer $lastRoll the last roll made.
     */
    private static $faces = 6;
    private $rolls = [];
    private $lastRoll = null;


    /**
     * Roll the dice.
     *
     * @param int $roll The roll if not null.
     * @return int as the roll;
     */
    public function roll($roll = null)
    {
        $roll = is_null($roll) ? rand(1, self::$faces) : $roll;
        $this->rolls[] = $roll;
        $this->lastRoll = $roll;
        return $roll;
    }


    /**
     * Empty the rolls.
     */
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
