<div class="col-12">
    <h1><?= $title ?></h1>
    <h4 class="post-meta">Senast uppdaterad <?= $app->esc($content->updated) ?></h4>
    <?= $app->textFilter->format($content->data, $content->filter) ?>
</div>
