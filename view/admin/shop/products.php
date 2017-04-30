<h1><?= $title ?></h1>
<? if ($app->session->has("message")) : ?>
    <p class="<?= $app->session->get("message")[0] ?>"><?= $app->esc($app->session->getOnce("message")[1]) ?></p>
<? endif; ?>
<table class="table center">
    <thead>
        <tr>
            <th></th>
            <th>Bild</th>
            <th>Beskrivning</th>
            <th>Kategori</th>
            <th>Pris</th>
            <th>Lager</th>
        </tr>
    </thead>
        <? foreach ($products as $product) : ?>
            <tr>
                <td>
                    <a href="<?= $this->url("user/admin/shop/edit/product/{$product->id}") ?>"><i class="material-icons">edit</i></a>
                    <a href="<?= $this->url("user/admin/shop/delete/product/{$product->id}") ?>"><i class="material-icons">delete</i></a>
                </td>
                <td><img src="<?= $this->asset("image/" . $app->esc($product->image) . "?w=50") ?>"></td>
                <td><?= $app->esc($product->description) ?></td>
                <td><?= $app->esc($product->category) ?></td>
                <td><?= $app->esc($product->price) ?></td>
                <td><?= $app->esc($product->amount) ?></td>
            </tr>
        <? endforeach; ?>
    <tbody>
    </tbody>
</table>
