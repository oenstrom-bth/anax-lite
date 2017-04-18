<div class="col-4">
    <figure class="figure">
        <img src="<?= $app->user->getGravatar(256); ?>" alt="<?= htmlentities($app->user->get("username")) ?> gravatar">
    </figure>
    <h2>@<?= htmlentities($app->user->get("username")) ?></h2>
    <a class="btn" href="<?= $this->url("user/edit") ?>">Redigera profil</a>
    <a class="btn" href="<?= $this->url("logout") ?>">Logga ut</a>
</div>

<div class="col-5">
    <h1><?= htmlentities($app->user->get("firstname")) . " " . htmlentities($app->user->get("lastname")) ?></h1>
    <h3>E-postadress</h3>
    <p><?= htmlentities($app->user->get("email")) ?></p>
    <h3>Födelsedatum</h3>
    <p><?= htmlentities($app->user->get("birthday")) ?></p>
    <h3>Biografi</h3>
    <p><?= htmlentities($app->user->get("bio")) ?></p>
</div>

<div class="col-3">
    <? if ($app->user->get("authority") === "admin") : ?>
        <h2>Administration</h2>
        <ul>
            <li><a href="<?= $this->url("user/admin/new") ?>">Ny medlem</a></li>
            <li><a href="<?= $this->url("user/admin/users") ?>">Visa medlemmar</a></li>
        </ul>
    <? endif; ?>
    <h3>Cookie-innehåll</h3>
    <p><?= htmlentities($app->cookie->get("username")) ?></p>
</div>
