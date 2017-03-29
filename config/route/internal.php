<?php
/**
 * Internal routes.
 */
$app->router->addInternal("404", function () use ($app) {
    $app->view->add("take1/header", ["title" => "Home"]);
    $app->view->add("take1/navbar");
    $app->view->add("take1/404");

    $app->response->setBody([$app->view, "render"])->send(404);
});
