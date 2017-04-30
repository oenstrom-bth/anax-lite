<?php

namespace Oenstrom\DiceGame;

/**
 * Class for handling the Dice game.
 */
class Game
{
    /**
     * @var integer $player the player "id".
     * @var Round $round Round object.
     * @var array $playerList List of players.
     * @var string $winner The winner.
     */
    private $player;
    private $round;
    private $playerList;
    public $winner;


    /**
     * Constructor
     *
     * @param integer $number The number of players.
     */
    public function __construct($number = 2)
    {
        $this->round = new \Oenstrom\DiceGame\Round();
        $this->player = 0;
        $this->winner = null;
        $this->playerList = $this->createPlayers($number);
    }


    /**
     * Create all the players.
     *
     * @param int $number The number of players to create.
     *
     * @return array as the player list.
     */
    private function createPlayers($number)
    {
        $players = [];
        for ($i = 1; $i <= $number; $i++) {
            $players[] = [
                "name" => "Spelare " . $i,
                "score" => 0,
            ];
        }
        return $players;
    }


    /**
     * Set next player in turn and set a new dice.
     */
    private function nextPlayer()
    {
        $new = $this->player + 1;
        $this->player = array_key_exists($new, $this->playerList) ? $new : 0;
    }


    /**
     * Handle the incoming route.
     *
     * @param string as the route.
     */
    public function handle($route)
    {
        $sameRound = true;

        if ($route == "reset") {
            $this->__construct(count($this->playerList));
        } else if ($route == "roll") {
            $sameRound = $this->round->roll();
        } else if ($route == "save") {
            $score = $this->getCurrentScore();
            if ($score > 0) {
                $this->playerList[$this->player]["score"] += $score;
                $sameRound = false;
            }
        }
        if (!$sameRound) {
            $this->round->newRound();
            $this->nextPlayer();
        }
    }


    /**
     * Get the array of players.
     *
     * @return array as the player list.
     */
    public function getPlayerList()
    {
        return $this->playerList;
    }


    /**
     * Returns true if there is a player with a score of 100 or more.
     *
     * @return bool as winner or not.
     */
    public function hasWinner()
    {
        foreach ($this->playerList as $player) {
            if ($player["score"] >= 100) {
                $this->winner = $player["name"];
                return true;
            }
        }
    }


    /**
     * Get the latest roll.
     *
     * @return int as the last roll.
     */
    public function getLastRoll()
    {
        return $this->round->getLastRoll();
    }


    /**
     * Get the current player's rolls as a comma seperated string.
     *
     * @return string as the rolls.
     */
    public function getRolls()
    {
        return implode(", ", $this->round->getRolls());
    }


    /**
     * Get the total score of the current player's rolls.
     *
     * @return int as the score.
     */
    public function getCurrentScore()
    {
        return $this->round->getScore();
    }


    /**
     * Get the current player name.
     *
     * @return string as the player name.
     */
    public function getPlayer()
    {
        return $this->getPlayerList()[$this->player]["name"];
    }
}
