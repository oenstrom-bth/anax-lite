<div class="col-12">
    <h1>Registrera ny användare</h1>
    <form method="POST" class="form">
        <? if ($app->session->has("message")) : ?>
            <p class="<?= $app->session->get("message")[0] ?>"><?= $app->session->getOnce("message")[1] ?></p>
        <? endif; ?>
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label>Användarnamn *
                        <input type="text" name="username" maxlength="64" autofocus>
                    </label>
                </div>
                <div class="form-group">
                    <label>E-postadress *
                        <input type="text" name="email" maxlength="64">
                    </label>
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label>Lösenord *
                        <input type="password" name="password">
                    </label>
                </div>
                <div class="form-group">
                    <label>Lösenordet igen *
                        <input type="password" name="re_password">
                    </label>
                </div>
            </div>
            <? if($app->request->getRoute() === "user/admin/new") : ?>
                <div class="form-group">
                    <label>Behörighet
                        <div class="radio-group">
                            <label><input type="radio" name="authority" value="user" checked> Användare</label>
                            <label><input type="radio" name="authority" value="admin"> Admin</label>
                        </div>
                    </label>
                </div>
            <? endif; ?>
        </div>
        <input class="btn" type="submit" name="user-form" value="Registrera">
    </form>
</div>
