<div class="col-12">
    <h1>Redigera profil</h1>
    <? if ($app->session->has("message")) : ?>
        <p class="<?= $app->session->get("message")[0] ?>"><?= $app->session->getOnce("message")[1] ?></p>
    <? endif; ?>
    <form method="POST" class="form">
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label>Förnamn
                        <input type="text" name="firstname" maxlength="64" value="<?= htmlentities($user->get("firstname")) ?>">
                    </label>
                </div>
                <div class="form-group">
                    <label>Efternamn
                        <input type="text" name="lastname" maxlength="64"  value="<?= htmlentities($user->get("lastname")) ?>">
                    </label>
                </div>
                <div class="form-group">
                    <label>Födelsedag
                        <input type="date" name="birthday" value="<?= htmlentities($user->get("birthday")) ?>">
                    </label>
                </div>
                <div class="form-group">
                    <label>Biografi
                        <textarea name="bio"><?= htmlentities($user->get("bio")) ?></textarea>
                    </label>
                </div>
            </div>

            <div class="col-6">
                <? if($app->request->getRoute() !== "user/edit") : ?>
                    <div class="form-group">
                        <label>Användarnamn *
                            <input type="text" name="username" maxlength="64" value="<?= htmlentities($user->get("username")) ?>">
                        </label>
                    </div>
                <? endif; ?>

                <div class="form-group">
                    <label>E-postadress *
                        <input type="email" name="email" maxlength="64" value="<?= htmlentities($user->get("email")) ?>">
                    </label>
                </div>

                <? if($app->request->getRoute() === "user/edit") : ?>
                    <div class="form-group">
                        <label>Nuvarande lösenord *
                            <input type="password" name="old_password">
                        </label>
                    </div>
                <? endif; ?>

                <div class="form-group">
                    <label>Nytt lösenord
                        <input type="password" name="new_password">
                    </label>
                </div>
                <div class="form-group">
                    <label>Nya lösenordet igen
                        <input type="password" name="re_password">
                    </label>
                </div>
                <p>Lämna fälten för det nya lösenordet tomma för att behålla det gamla lösenordet.</p>
            </div>
        </div>
        <input class="btn" type="submit" name="user-form" value="Redigera">
        <? if($app->user->get("authority") === "admin") : ?>
            <a class="btn" href="<?= $this->url("user/admin/block/{$user->get("username")}") ?>"><?= $user->get("isBanned") ? "Avblockera" : "Blockera" ?></a>
            <a class="btn" href="<?= $this->url("user/admin/remove/{$user->get("username")}") ?>">Ta bort</a>
        <? endif; ?>
    </form>
</div>
