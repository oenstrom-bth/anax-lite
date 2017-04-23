<div class="col-12">
    <h1>Redigera innehåll</h1>
    <? if ($app->session->has("message")) : ?>
        <p class="<?= $app->session->get("message")[0] ?>"><?= $app->esc($app->session->getOnce("message")[1]) ?></p>
    <? endif; ?>
    <form method="POST" class="form full-width">
        <div class="form-group">
            <label>Titel
                <input type="text" name="title" value="<?= $app->esc($content->get("title")); ?>" placeholder="Mitt första blogginlägg" required>
            </label>
        </div>

        <div class="form-group">
            <label>Path:
                <input type="text" name="path" value="<?= $app->esc($content->get("path")); ?>" placeholder="blogpost-1">
            </label>
        </div>

        <div class="form-group">
            <label>Slug
                <input type="text" name="slug" value="<?= $app->esc($content->get("slug")); ?>" placeholder="mitt-forsta-blogginlagg">
            </label>
        </div>

        <div class="form-group">
            <label>Text
                <textarea name="data" rows="10"><?= $app->esc($content->get("data")); ?></textarea>
            </label>
        </div>

        <div class="form-group">
            <label>Typ
                <select name="type">
                    <option value="page"<?= $content->get("type") === "page" ? " selected" : "" ?>>Sida</option>
                    <option value="post"<?= $content->get("type") === "post" ? " selected" : "" ?>>Inlägg</option>
                    <option value="block"<?= $content->get("type") === "block" ? " selected" : "" ?>>Block</option>
                </select>
            </label>
        </div>

        <div class="form-group">
            <label>Filter
                <input type="text" name="filter" value="<?= $app->esc($content->get("filter")); ?>" placeholder="esc,markdown">
            </label>
        </div>

        <div class="form-group">
            <label>Publicera
                <input type="datetime" name="published" value="<?= $app->esc($content->get("published")); ?>" placeholder="åååå-mm-dd hh:mm:ss">
            </label>
        </div>

        <input type="submit" class="btn" name="edit" value="Spara">
        <a href="<?= $this->url("user/admin/content/delete/" . $content->get("id")) ?>" class="btn"><?= $content->get("deleted") ? "Lägg tillbaka" : "Ta bort" ?></a>
    </form>
</div>
