<?php
/**
 * Internal routes.
 */

$app->router->addInternal("404", function () use ($app) {
    $data = ["title" => "404 - Hittades ej"];
    $app->view->add("view/layout", $data, "layout");

    $app->view->add("view/flash", ["region" => "flash"], "flash", 0);
    $app->view->add("view/404", ["region" => "main"], "main", 0);
    $app->view->add("view/footer", ["region" => "footer"], "footer", 0);

    $body = $app->view->renderBuffered("layout");
    $app->response->setBody($body)->send();
});
