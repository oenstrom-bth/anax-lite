<h1>Filter/format: 'link'</h1>
<p>Utan filter: https://google.com - Med filter: <?= $app->textFilter->format("https://google.com", "link"); ?></p>

<h1>Filter/format: 'strip'</h1>
<p>Utan filter: <span style="color: red">Röd text</span> - Med filter: <?= $app->textFilter->format("<span style='color: red'>Röd text</span>", "strip"); ?></p>

<h1>Filter/format: 'esc'</h1>
<p>Utan filter: <a href="#">Länk</a> - Med filter: <?= $app->textFilter->format("<a href='#'>Länk</a>", "esc"); ?></p>

<hr>

<div class="row">
    <div class="col-6">
        <h1>Markdown</h1>
        <?= $app->textFilter->format($markdown, "markdown"); ?>
        <hr>
        <h1>Esc och Markdown</h1>
        <?= $app->textFilter->format($markdown, "esc,markdown"); ?>
    </div>
    <div class="col-6">
        <h1>BBCode</h1>
        <?= $app->textFilter->format($bbcode, "bbcode"); ?>
        <h1>BBCode och nl2br</h1>
        <?= $app->textFilter->format($bbcode, "bbcode,nl2br"); ?>
        <hr>
        <h1>Markdown och BBCode</h1>
        <?= $app->textFilter->format($markdown, "markdown,bbcode"); ?>
    </div>
</div>
