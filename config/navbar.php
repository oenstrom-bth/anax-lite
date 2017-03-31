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
        "test" => [
            "text" => "Test",
            "route" => "test",
            "items" => [
                "test1" => [
                    "text" => "Test 1",
                    "route" => "test/1",
                ],
                "test2" => [
                    "text" => "Test 2",
                    "route" => "test/2",
                ],
                "test3" => [
                    "text" => "Test 3",
                    "route" => "test/3",
                    "items" => [
                        "test3-1" => [
                            "text" => "Test 3.1",
                            "route" => "test/3/1",
                        ],
                        "test3-2" => [
                            "text" => "Test 3.2",
                            "route" => "test/3/2",
                            "items" => [
                                "test3-2-1" => [
                                    "text" => "Test 3.2.1",
                                    "route" => "test/3/2/1",
                                ],
                                "test3-2-2" => [
                                    "text" => "Test 3.2.2",
                                    "route" => "test/3/2/2",
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]
    ]
];
