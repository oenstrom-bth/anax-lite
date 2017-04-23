<div class="col-12">
    <h1>Blogginlägg</h1>
    <div class="blog-wrapper">
    <? foreach ($posts as $post) : ?>
        <div class="blog-post">
            <h2><?= $app->esc($post->get("title")) ?></h2>
            <h4 class="post-meta">Senast uppdaterad <?= $post->get("updated") ?></h4>
            <?= $app->textFilter->format($post->getPreamble(), $post->get("filter")) ?>
            <a href="<?= $this->url("blog/{$post->get("slug")}") ?>" class="read-more">Läs mer <i class="material-icons">chevron_right</i></a>
        </div>
    <? endforeach; ?>
    </div>
</div>
