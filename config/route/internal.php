<?php
/**
 * Internal routes.
 */

$app->router->addInternal("404", function () use ($app) {
    $app->renderPage("view/404", ["title" => "404 - Hittades ej"]);
});
