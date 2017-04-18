<?php

namespace Oenstrom\App;

/**
 * An App class to wrap the resources of the framework.
 */
class App
{
    /**
     * Redirects the user to the route specified in the path.
     *
     * @param string $path The location to redirect to.
     *
     * @SuppressWarnings(PHPMD.ExitExpression)
     */
    public function redirect($path)
    {
        header("Location: " . $this->url->create($path));
        exit;
    }
}
