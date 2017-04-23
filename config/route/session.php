<?php
/**
 * Session routes
 */

/**
 * Route for session start page and dump page.
 */
$sessionCallback = function () use ($app) {
    $app->renderPage("view/session", ["title" => "Session"]);
};
$app->router->add("session", $sessionCallback);
$app->router->add("session/dump", $sessionCallback);


/**
 * Route for session increment.
 */
$app->router->add("session/increment", function () use ($app) {
    $app->session->set("number", $app->session->get("number") + 1);
    $app->redirect("session");
});


/**
 * Route for session decrement.
 */
$app->router->add("session/decrement", function () use ($app) {
    $app->session->set("number", $app->session->get("number") - 1);
    $app->redirect("session");
});


/**
 * Route for session status.
 */
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


/**
 * Route for session destroy.
 */
$app->router->add("session/destroy", function () use ($app) {
    $app->session->destroy();
    $app->redirect("session/dump");
});
