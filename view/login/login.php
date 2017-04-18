<div class="col-8">
    <h1>Logga in</h1>
    <form method="POST" class="form">
        <? if ($app->session->has("message")) : ?>
            <p class="<?= $app->session->get("message")[0] ?>"><?= $app->session->getOnce("message")[1] ?></p>
        <? endif; ?>
        <div class="form-group">
            <label>Användarnamn
                <input type="text" name="username" required autofocus value="<?= htmlentities($app->cookie->get("username")) ?>">
            </label>
        </div>
        <div class="form-group">
            <label for="password">Lösenord
                <input type="password" name="password" required>
            </label>
        </div>
        <input class="btn" type="submit" name="login" value="Logga in">
    </form>
</div>

<div class="col-4">
    <h2>Ingen användare?</h2>
    <p>Klicka på knappen nedan för att registrera en ny användare.</p>
    <a href="<?= $this->url("register") ?>" class="btn">Ny användare</a>
