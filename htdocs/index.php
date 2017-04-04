<?php
/**
 * Bootstrap the framework.
 */
// Where are all the files? Both are needed by Anax.
define("ANAX_INSTALL_PATH", realpath(__DIR__ . "/.."));
define("ANAX_APP_PATH", ANAX_INSTALL_PATH);

// Include essentials
require ANAX_INSTALL_PATH . "/config/error_reporting.php";

// Get the autoloader by using composers version.
require ANAX_INSTALL_PATH . "/vendor/autoload.php";

// Add all resources to $app
$app           = new \Oenstrom\App\App();
$app->request  = new \Anax\Request\Request();
$app->response = new \Anax\Response\Response();
$app->url      = new \Anax\Url\Url();
$app->router   = new \Anax\Route\RouterInjectable();
$app->view     = new \Anax\View\ViewContainer();
$app->navbar   = new \Oenstrom\Navbar\Navbar();

$app->navbar->configure("navbar.php");
// Inject $app into the view container for use in view files.
$app->view->setApp($app);

// Update view configuration with values from config file.
$app->view->configure("view.php");

// Init the object of the request class.
$app->request->init();

// Init the url-object with default values from the request object.
$app->url->setSiteUrl($app->request->getSiteUrl());
$app->url->setBaseUrl($app->request->getBaseUrl());
$app->url->setStaticSiteUrl($app->request->getSiteUrl());
$app->url->setStaticBaseUrl($app->request->getBaseUrl());
$app->url->setScriptName($app->request->getScriptName());

// Update url configuration with values from config file.
$app->url->configure("url.php");
$app->url->setDefaultsFromConfiguration();


$app->style = $app->url->asset("css/style.min.css");

//$app->navbar->setApp($app);
$app->navbar->setCurrentRoute($app->request->getRoute());
$app->navbar->setUrlCreator([$app->url, "create"]);

// Load the routes
require ANAX_INSTALL_PATH . "/config/route.php";

// Load the navbar (kanske inte bästa sättet...)
//$app->navbar = require ANAX_INSTALL_PATH . "/config/navbar.php";

// Leave to router to match incoming request to routes
$app->router->handle($app->request->getRoute(), $app->request->getMethod());
