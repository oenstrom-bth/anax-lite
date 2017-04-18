<?php
/**
 * Session routes
 */
$sessionCallback = function () use ($app) {
    $data = ["title" => "Session"];
    $app->view->add("view/layout", $data, "layout");

    $app->view->add("view/flash", ["region" => "flash"], "flash", 0);
    $app->view->add("view/session", ["region" => "main"], "main", 0);
    $app->view->add("view/footer", ["region" => "footer"], "footer", 0);

    $body = $app->view->renderBuffered("layout");
    $app->response->setBody($body)->send();
};

$app->router->add("session", $sessionCallback);

$app->router->add("session/dump", $sessionCallback);


$app->router->add("session/increment", function () use ($app) {
    $app->session->set("number", $app->session->get("number") + 1);
    header("Location: " . $app->url->create("session"));
    exit;
});

$app->router->add("session/decrement", function () use ($app) {
    $app->session->set("number", $app->session->get("number") - 1);
    header("Location: " . $app->url->create("session"));
    exit;
});

$app->router->add("session/status", function () use ($app) {
    $data = [
        "session_id" => session_id(),
        "session_cache_expire" => session_cache_expire(),
        "session_cache_limiter" => session_cache_limiter(),
        "session_status" => session_status(),
        "session_save_path" => session_save_path(),
    ];
    $app->response->sendJson($data);
});

$app->router->add("session/destroy", function () use ($app) {
    $app->session->destroy();
    header("Location: " . $app->url->create("session/dump"));
    exit;
});
