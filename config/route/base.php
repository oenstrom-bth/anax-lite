<?php
/**
 * Base routes.
 */

$app->router->add("", function () use ($app) {
    $data = ["title" => "Hem"];
    $app->view->add("view/layout", $data, "layout");

    $app->view->add("view/flash", ["region" => "flash"], "flash", 0);
    $app->view->add("view/home", ["region" => "main"], "main", 0);
    $app->view->add("view/footer", ["region" => "footer"], "footer", 0);

    $body = $app->view->renderBuffered("layout");
    $app->response->setBody($body)->send();
});

$app->router->add("about", function () use ($app) {
    $data = ["title" => "Om sidan"];
    $app->view->add("view/layout", $data, "layout");

    $app->view->add("view/flash", ["region" => "flash"], "flash", 0);
    $app->view->add("view/about", ["region" => "main"], "main", 0);
    $app->view->add("view/footer", ["region" => "footer"], "footer", 0);

    $body = $app->view->renderBuffered("layout");
    $app->response->setBody($body)->send();
});

$app->router->add("report", function () use ($app) {
    $data = ["title" => "Redovisning"];
    $app->view->add("view/layout", $data, "layout");

    $app->view->add("view/flash", ["region" => "flash"], "flash", 0);
    $app->view->add("view/report", ["region" => "main"], "main", 0);
    $app->view->add("view/footer", ["region" => "footer"], "footer", 0);

    $body = $app->view->renderBuffered("layout");
    $app->response->setBody($body)->send();
});

$diceRoute = function ($route = null) use ($app) {
    $data = ["title" => "Tärningsspel"];
    $app->view->add("view/layout", $data, "layout");

    $app->view->add("view/flash", ["region" => "flash"], "flash", 0);
    $app->view->add("view/dice", ["region" => "main", "route" => $route], "main", 0);
    $app->view->add("view/footer", ["region" => "footer"], "footer", 0);

    $body = $app->view->renderBuffered("layout");
    $app->response->setBody($body)->send();
};
$app->router->add("dice", $diceRoute);
$app->router->add("dice/{route}", $diceRoute);

$app->router->add("test", function () use ($app) {
    $data = ["title" => "Testsida"];
    $app->view->add("view/layout", $data, "layout");

    $app->view->add("view/flash", ["region" => "flash"], "flash", 0);
    $app->view->add("view/test", ["region" => "main", "message" => "Hello world"], "main", 0);
    $app->view->add("view/footer", ["region" => "footer"], "footer", 0);

    $body = $app->view->renderBuffered("layout");
    $app->response->setBody($body)->send();
});


$app->router->add("status", function () use ($app) {
    $data = [
        "Server" => php_uname(),
        "PHP version" => phpversion(),
        "Included files" => count(get_included_files()),
        "Memory used" => memory_get_peak_usage(true),
        "Execution time" => microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"],
        "Interface type" => php_sapi_name(),
        "More details" => [
            $_SERVER
        ]
    ];
    $app->response->sendJson($data);
});
