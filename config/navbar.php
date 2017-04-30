<?php
/**
 * Config file for navbar.
 */
return [
    "config" => [
        "class" => "navbar"
    ],
    "items" => [
        "home" => [
            "text" => "Hem",
            "route" => "",
        ],
        "about" => [
            "text" => "Om",
            "route" => "about",
        ],
        "report" => [
            "text" => "Redovisning",
            "route" => "report",
        ],
        "tasks" => [
            "text" => "Uppgifter",
            "route" => "#",
            "items" => [
                "kmom02" => [
                    "text" => "Kmom02",
                    "route" => "#",
                    "items" => [
                        "session" => [
                            "text" => "Session",
                            "route" => "session",
                        ],
                        "dice" => [
                            "text" => "Tärning",
                            "route" => "dice",
                        ],
                    ],
                ],
                "kmom04" => [
                    "text" => "Kmom04",
                    "route" => "#",
                    "items" => [
                        "textfilter" => [
                            "text" => "Textfilter",
                            "route" => "textfilter",
                        ],
                        "blog" => [
                            "text" => "Blogg",
                            "route" => "blog",
                        ],
                        "page" => [
                            "text" => "DB-sida",
                            "route" => "page/content-test-page",
                        ],
                        "block" => [
                            "text" => "Sida med block",
                            "route" => "page-with-block",
                        ],
                    ],
                ],
                "kmom05" => [
                    "text" => "Kmom05",
                    "route" => "#",
                    "items" => [
                        "shop" => [
                            "text" => "Webbshop",
                            "route" => "user/admin/shop",
                        ],
                    ],
                ],
            ],
        ]
    ]
];
