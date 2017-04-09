<?php

namespace Oenstrom\DiceGame;

class Round
{
    private $dice;


    /**
     * Constructor
     *
     * @return self
     */
    public function __construct()
    {
        $this->dice = new \Oenstrom\DiceGame\Dice();
    }


    public function newRound()
    {
        $this->dice->emptyRolls();
    }


    /**
     * Roll the dice.
     *
     * @return bool as valid roll.
     */
    public function roll()
    {
        $roll = $this->dice->roll();
        if ($roll == 1) {
            return false;
        }
        return true;
    }


    /**
     * Get rolls made this round.
     *
     * @return array as the list of rolls.
     */
    public function getRolls()
    {
        return $this->dice->getRolls();
    }


    /**
     * Get the last roll made.
     *
     * @return int as the last roll.
     */
    public function getLastRoll()
    {
        return $this->dice->getLastRoll();
    }


    /**
     * Get the current score of the round.
     *
     * @return int as the score.
     */
    public function getScore()
    {
        return $this->dice->getTotal();
    }
}
