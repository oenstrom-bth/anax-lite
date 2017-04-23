<?php
/**
 * Base routes.
 */


/**
 * Route for homepage.
 */
$app->router->add("", function () use ($app) {
    $app->renderPage("view/home", ["title" => "Hem"]);
});


/**
 * Route for about page.
 */
$app->router->add("about", function () use ($app) {
    $app->renderPage("view/about", ["title" => "Om sidan"]);
});


/**
 * Route for report page.
 */
$app->router->add("report", function () use ($app) {
    $app->renderPage("view/report", ["title" => "Redovisning"]);
});


/**
 * Route for dice game.
 */
$diceRoute = function ($route = null) use ($app) {
    $app->renderPage("view/dice", ["title" => "Tärningsspel", "route" => $route]);
};
$app->router->add("dice", $diceRoute);
$app->router->add("dice/{route}", $diceRoute);


/**
 * A test route
 */
$app->router->add("test", function () use ($app) {
    $app->renderPage("view/test", ["title" => "Testsida", "message" => "Hello world"]);
});


/**
 * Route for PHP info.
 */
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




/**
 * Route for testing text filter.
 */
$app->router->add("textfilter", function () use ($app) {
    $app->renderPage("textfilter/textfilter", [
        "title" => "Textfilter",
        "markdown" => file_get_contents(ANAX_APP_PATH . "/view/textfilter/markdown.md"),
        "bbcode" => file_get_contents(ANAX_APP_PATH . "/view/textfilter/bbcode.txt"),
    ]);
});


/**
 * Route for testing a page with a block.
 */
$app->router->add("page-with-block", function () use ($app) {
    $app->addBlock("sidebar-links", "sidebar-right", 0);
    $app->renderPage("view/test", ["title" => "Blogginlägg"]);
});


/**
 * Route for displaying all blog posts.
 */
$app->router->add("blog", function () use ($app) {
    $contentDao = new \Oenstrom\Content\ContentDao($app->db);
    $posts = $contentDao->getAll("post", "published", "\Oenstrom\Content\Blog");
    $app->renderPage("view/blog", ["title" => "Blogginlägg", "posts" => $posts]);
});


/**
 * Route for displaying a blog post.
 */
$app->router->add("blog/{slug}", function ($slug) use ($app) {
    $contentDao = new \Oenstrom\Content\ContentDao($app->db);
    $post = $contentDao->getContent("post", $slug);
    if (!$post) {
        $app->redirect("404");
    }
    $app->renderPage("view/page-post", ["title" => $app->esc($post->title), "content" => $post]);
});


/**
 * Route for display a db page.
 */
$app->router->add("page/{path}", function ($path) use ($app) {
    $contentDao = new \Oenstrom\Content\ContentDao($app->db);
    $page = $contentDao->getContent("page", $path);
    if (!$page) {
        $app->redirect("404");
    }
    $app->renderPage("view/page-post", ["title" => $app->esc($page->title), "content" => $page]);
});
