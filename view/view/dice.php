<?php
$session = new \Oenstrom\Session\Session("olen-16-anax-lite-dice");
$session->start();

$diceGame = $session->has("diceGame") ? $session->get("diceGame") : new \Oenstrom\DiceGame\Game();
$diceGame->handle($route);

$session->set("diceGame", $diceGame);
?>


<div class="row">
    <div class="col-3">
        <h2>Poäng</h2>
        <? foreach ($diceGame->getPlayerList() as $player) : ?>
            <p><?= $player["name"] . ": " . $player["score"] ?></p>
        <? endforeach; ?>
    </div>

    <div class="col-5">
        <? if ($diceGame->hasWinner()) : ?>

        <h1><?= $diceGame->winner ?> vann!</h1>

        <? else : ?>

        <h1><?= $diceGame->getPlayer() ?></h1>
        <p>Senaste kastet: <?= $diceGame->getLastRoll() ?></p>
        <p>Kasthistorik: <?= $diceGame->getRolls() ?></p>
        <p>Poäng: <?= $diceGame->getCurrentScore() ?></p>

        <a class="btn" href="<?= $this->url("dice/roll") ?>">Kasta tärning</a>
        <a class="btn" href="<?= $this->url("dice/save") ?>">Spara poäng</a>

        <? endif; ?>
        <a class="btn" href="<?= $this->url("dice/reset") ?>">Starta om</a>
    </div>

    <div class="col-4">
        <h2>Regler</h2>
        <ul>
            <li>Först till hundra vinner.</li>
            <li>Kasta tärningen för att samla poäng.</li>
            <li>Rundan pågår tills du slår en etta eller väljer att spara.</li>
            <li>En etta återställer poängen för rundan.</li>
        </ul>
    </div>
</div>
