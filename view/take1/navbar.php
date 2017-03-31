<?php

/**
 * Recursive function that generates a multi-level HTML list based on an array.
 *
 * @param array $items the array to loop through.
 * @param object $app the wrapper for the framework resources.
 *
 * @return string as the generated html code.
 */
function listFromArray($items, $app)
{
    $html = "<ul>";
    foreach ($items as $item) {
        $currRoute = $app->request->getRoute() === $item["route"] ? ' class="active"' : '';
        $html .= "<li$currRoute>";
        $html .= "<a href='{$app->url->create($item["route"])}'>{$item["text"]}</a>";
        if (isset($item["items"])) {
            $html .= listFromArray($item["items"], $app);
        }
        $html .= "</li>";
    }
    $html .= "</ul>";
    return $html;
}

?>
                <nav class="<?= $app->navbar["config"]["class"] ?>">
                    <?= listFromArray($app->navbar["items"], $app) ?>
                </nav>
            </div>
        </div>
    </div>
</div>
