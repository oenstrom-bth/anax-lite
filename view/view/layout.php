<!doctype html>
<html lang="sv">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <link href="<?= $app->url->asset("css/style.min.css") ?>" rel="stylesheet" type="text/css">
    <title><?= $title ?> - Olof Enström</title>
</head>
<body>
    <div class="site-wrapper">
        <div class="outer-wrapper outer-wrapper-header">
            <div class="inner-wrapper">
                <div class="row">
                    <h1 class="title col-4"><a href="<?= $this->url("") ?>">Olof Enström</a></h1>
                    <div class="col-8">
                        <nav class="<?= $app->navbar->getClass() ?>">
                            <?= $app->navbar->getHtml() ?>
                        </nav>
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
</body>
</html
