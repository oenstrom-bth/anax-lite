<div class="col-12">
    <h1>404 - Sidan hittades inte</h1>
    <p>Routen '<?= $app->request->getRoute() ?>' kunde inte hittas!</p>
    <h2>Laddad routes</h2>
    <p>Följande routes är laddade:</p>
    <ul>
        <?php foreach ($app->router->getAll() as $route) : ?>
            <li>'<?= $route->getRule() ?>'</li>
        <?php endforeach; ?>
    </ul>
    <p>Följande interna routes är laddade:</p>
    <ul>
        <?php foreach ($app->router->getInternal() as $route) : ?>
            <li>'<?= $route->getRule() ?>'</li>
        <?php endforeach; ?>
    </ul>
</div>
