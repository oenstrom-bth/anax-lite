<h1><?= $title ?></h1>

<form method="POST" class="form">
    <? if (isset($categories)) : ?>
        <div class="form-group">
            <select name="id">
                <? foreach ($categories as $category) : ?>
                    <option value="<?= $app->esc($category->id) ?>"><?= $app->esc($category->category) ?></option>
                <? endforeach; ?>
            </select>
        </div>
    <? endif; ?>
    <div class="form-group">
        <label><?= isset($categories) ? "Nytt kategorinamn" : "Kategorinamn" ?>
            <input type="text" name="category" maxlength="20">
        </label>
    </div>
    <input type="submit" name="submitCategory" value="<?= $title ?>" class="btn">
</form>
