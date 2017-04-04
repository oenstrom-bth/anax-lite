<?php
/**
 * Base routes.
 */

$app->router->add("", function () use ($app) {
    $app->view->add("take1/header", ["title" => "Hem"]);
    $app->view->add("navbar2/navbar");
    $app->view->add("take1/flash");
    $app->view->add("take1/home");
    $app->view->add("take1/footer");

    $app->response->setBody([$app->view, "render"])
                            ->send();
});

$app->router->add("about", function () use ($app) {
    $app->view->add("take1/header", ["title" => "Om sidan"]);
    $app->view->add("navbar2/navbar");
    $app->view->add("take1/flash");
    $app->view->add("take1/about");
    $app->view->add("take1/byline");
    $app->view->add("take1/footer");

    $app->response->setBody([$app->view, "render"])
                            ->send();
});

$app->router->add("report", function () use ($app) {
    $app->view->add("take1/header", ["title" => "Redovisning"]);
    $app->view->add("navbar2/navbar");
    $app->view->add("take1/flash");
    $app->view->add("take1/report");
    $app->view->add("take1/byline");
    $app->view->add("take1/footer");

    $app->response->setBody([$app->view, "render"])
                            ->send();
});

$app->router->add("test", function () use ($app) {
    $app->view->add("take1/header", ["title" => "Teststida"]);
    $app->view->add("navbar2/navbar");
    $app->view->add("take1/flash");
    $app->view->add("take1/test");
    $app->view->add("take1/byline");
    $app->view->add("take1/footer");

    $app->response->setBody([$app->view, "render"])
                            ->send();
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
