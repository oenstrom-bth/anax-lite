<div class="col-12">
    <? if ($app->session->has("message")) : ?>
        <p class="<?= $app->session->get("message")[0] ?>"><?= $app->session->getOnce("message")[1] ?></p>
    <? endif; ?>

    <h1><?= $title ?></h1>
    <p>Visa:
        <a href="<?= $this->url("user/admin/content/overview/published") ?>">Publicerade</a>
        <a href="<?= $this->url("user/admin/content/overview/nonpublished") ?>">Opublicerade</a>
        <a href="<?= $this->url("user/admin/content/overview/deleted") ?>">Borttagna</a>
    </p>
    <div class="table-wrapper">
        <table class="table center">
            <thead>
                <tr>
                    <th></th>
                    <th>ID</th>
                    <th>Path</th>
                    <th>Slug</th>
                    <th>Titel</th>
                    <th>Publicerad</th>
                    <th>Skapad</th>
                    <th>Uppdaterad</th>
                    <th>Borttagen</th>
                </tr>
            </thead>
            <tbody>
            <? foreach($content as $item) : ?>
                <tr>
                    <td><a href="<?= $app->esc($this->url("user/admin/content/edit/{$item->get("id")}")) ?>"><i class="material-icons">edit</i></a></td>
                    <td><?= $app->esc($item->get("id")) ?></td>
                    <td><?= $app->esc($item->get("path")) ?></td>
                    <td><?= $app->esc($item->get("slug")) ?></td>
                    <td><?= $app->esc($item->get("title")) ?></td>
                    <td><?= $app->esc($item->get("published")) ?></td>
                    <td><?= $app->esc($item->get("created")) ?></td>
                    <td><?= $app->esc($item->get("updated")) ?></td>
                    <td><?= $app->esc($item->get("deleted")) ?></td>
                </tr>
            <? endforeach; ?>
            </tbody>
        </table>
        <? if (!$content) : ?>
            <p>Inget att visa.</p>
        <? endif; ?>
    </div>
</div>
