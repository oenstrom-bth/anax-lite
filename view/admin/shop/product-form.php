<h1><?= $title ?></h1>

<form method="POST" class="form">
    <div class="form-group">
        <label>Namn/Beskrivning
            <input type="text" name="description" value="<?= isset($edit) ? $app->esc($product->description) : "" ?>">
        </label>
    </div>

    <div class="form-group">
        <label>Pris
            <input type="number" name="price" value="<?= isset($edit) ? $app->esc($product->price) : "" ?>">
        </label>
    </div>

    <div class="form-group">
        <label>Antal i lager
            <input type="number" name="amount" value="<?= isset($edit) ? $app->esc($product->amount) : "" ?>">
        </label>
    </div>

    <div class="form-group">
        <label>Produktbild
            <input type="text" name="image" value="<?= isset($edit) ? $app->esc($product->image) : "" ?>">
        </label>
    </div>

    <div class="form-group">
        <label>Kategorier
            <? foreach ($categories["allCategories"] as $category) : ?>
                <label><input type="checkbox" name="categories[]"<?= in_array($category->category, $categories["checked"]) ? " checked " : "" ?>value="<?= $app->esc($category->id) ?>"> <span><?= $app->esc($category->category) ?></span></label>
            <? endforeach; ?>
        </label>
    </div>

    <input type="submit" name="submitProduct" value="<?= $title ?>" class="btn">
</form>
