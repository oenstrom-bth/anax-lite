<div class="col-12">
    <h1>Testsida</h1>
    <pre>
        <?php foreach (get_defined_vars() as $key => $val) : ?>
            <li><?= $key ?></li>
        <?php endforeach; ?>
    </pre>
    <p><?= $message ?></p>
    <p>Here is a link to a static asset <a href="<?= $this->asset("image/car.png") ?>">car.png</a>.</p>
    <p>Here is the same car within a paragraph as an image <img src="<?= $this->asset("image/car.png") ?>">, the image source is linked as a asset.</p>
    <p>Here are two links to the test routes: <a href="<?= $this->url("about") ?>">view/about</a> | <a href="<?= $this->url("report") ?>">view/report</a></p>
    <p>Here is a link to another site, like <a href="<?= $this->url("https://google.com") ?>">Google</a>.
</div>
