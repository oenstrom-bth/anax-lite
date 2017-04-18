<!doctype html>
<html lang="sv">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="<?= $this->asset("css/style.min.css") ?>" rel="stylesheet" type="text/css">
    <title><?= $title ?> - Olof Enström</title>
</head>
<body>
    <div class="site-wrapper">
        <div class="outer-wrapper outer-wrapper-header">
            <div class="inner-wrapper">
                <div class="row">
                    <h1 class="title col-4"><a href="<?= $this->url("") ?>">Olof Enström</a></h1>
                    <div class="col-8">
                        <div class="nav-wrapper">
                            <nav class="<?= $app->navbar->getClass() ?>">
                                <?= $app->navbar->getHtml() ?>
                            </nav>
                            <div id="user-button" class="user-button">
                                <i class="material-icons">account_circle</i>
                                <div id="user-alternatives" class="user-alternatives hide">
                                    <ul>
                                        <? if ($app->session->has("user")) : ?>
                                            <li><a href="<?= $this->url("user/profile") ?>">Inloggad som <?= $app->cookie->get("username") ?></a></li>
                                            <li><a href="<?= $this->url("user/profile") ?>">Din profil</a></li>
                                            <li><a href="<?= $this->url("logout") ?>">Logga ut</a></li>
                                        <? else : ?>
                                            <li><a href="<?= $this->url("login") ?>">Logga in</a></li>
                                            <li><a href="<?= $this->url("register") ?>">Registrera</a></li>
                                        <? endif; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    <?php if ($this->regionHasContent("flash")) : ?>
        <div class="outer-wrapper outer-wrapper-flash">
            <div class="inner-wrapper inner-wrapper-flash">
                <div class="row">
                    <div class="col-12">
                        <?php $this->renderRegion("flash") ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>


    <?php if ($this->regionHasContent("main")) : ?>
        <div class="outer-wrapper outer-wrapper-main">
            <div class="inner-wrapper inner-wrapper-main">
                <div class="row">
                    <?php $this->renderRegion("main") ?>
                </div>
            </div>
        </div>
    <?php endif; ?>


    <?php if ($this->regionHasContent("footer")) : ?>
        <div class="outer-wrapper outer-wrapper-footer">
            <div class="inner-wrapper">
                <div class="row">
                    <div class="col-12">
                        <?php $this->renderRegion("footer") ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>


    </div>
<script src="<?= $this->asset("js/user-button.js") ?>" type="text/javascript"></script>
</body>
</html>
