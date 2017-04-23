<?php
if ((isset($_POST["key"]) || isset($_POST["change"])) && isset($_POST["value"])) {
    if ($_POST["change"] != "none") {
        $app->session->set($_POST["change"], $_POST["value"]);
    } else {
        $app->session->set($_POST["key"], $_POST["value"]);
    }
}
?>

<h1>Session</h1>
<? if ($app->request->getRoute() == "session/dump") : ?>
<pre>
<? $app->session->dump() ?>
</pre>
<? else : ?>
<p><?= $app->session->get("number") ?></p>
<? endif; ?>

<a class="btn" href="<?= $this->url("session/increment") ?>">Increment</a>
<a class="btn" href="<?= $this->url("session/decrement") ?>">Decrement</a>
<a class="btn" href="<?= $this->url("session/status") ?>">Status</a>
<a class="btn" href="<?= $this->url("session/dump") ?>">Dump</a>
<a class="btn" href="<?= $this->url("session/destroy") ?>">Destroy</a>

<hr>

<h2>Lägg till eller ändra ett värde</h2>
<form method="POST" class="form">
    <div class="form-group">
        <label for="change">Ändra
            <select id="change" name="change">
                <option value="none">Välj nyckel</option>
                <?php foreach ($app->session->getKeys() as $key) : ?>
                    <option value="<?= $key ?>"><?= $key ?></option>
                <?php endforeach; ?>
            </select>
        </label>
    </div>
    <div class="form-group">
        <label for="key">Ny nyckel
            <input type="text" name="key" id="key">
        </label>
    </div>
    <div class="form-group">
        <label for="value">Value
                <input type="text" name="value" id="value">
            </label>
        </div>
    <input class="btn" type="submit" value="Lägg till">
</form>
