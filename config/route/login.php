<?php
/**
 * User/login/admin routes
 */

/**
 * Route for logging in.
 */
$app->router->add("login", function () use ($app) {
    if ($app->session->has("user")) {
        $app->redirect("user/profile");
    }
    $app->userAuth = new \Oenstrom\User\UserAuth($app->db, $app->form);

    if (isset($_POST["login"])) {
        $id = $app->userAuth->login($_POST["username"], $_POST["password"]);
        $app->cookie->set("username", $_POST["username"]);
        if ($id) {
            $app->session->set("user", $id);
            $app->redirect("user/profile");
        }
        $app->session->set("message", ["error", "Fel inloggningsuppgifter."]);
        $app->redirect("login");
    }

    $app->renderPage("login/login", ["title" => "Logga in"]);
});


/**
 * Route for registering a new user.
 */
$app->router->add("register", function () use ($app) {
    if (isset($_POST["user-form"])) {
        if (!$app->form->isFilled($_POST, ["username", "email", "password", "re_password"])) {
            $app->redirect("register");
        }
        $valid = ($app->form->validate($_POST, [
            "username" => "unique:username",
            "email" => "unique:email,email:",
            "password" => "same:re_password"
        ]));
        if (!$valid) {
            $app->redirect("register");
        }
        $userAuth = new \Oenstrom\User\UserAuth($app->db, $app->form);
        $userAuth->addUser($_POST);
        $app->session->set("message", ["success", "Ditt konto har skapats."]);
    }

    $app->renderPage("view/register", ["title" => "Registrera användare"]);
});


/**
 * Route for logging out.
 */
$app->router->add("logout", function () use ($app) {
    if ($app->session->has("user")) {
        $app->session->delete("user");
        $app->session->destroy();
        $app->redirect("login");
    }
    $app->redirect("");
});


/**
 * Route effecting all user routes.
 */
$app->router->add("user/**", function () use ($app) {
    if (!$app->session->has("user")) {
        $app->redirect("login");
    }
    $app->db->connect();
    $app->db->execute("SELECT * FROM anax_users WHERE id = :id;", [":id" => $app->session->get("user")]);
    $app->user = $app->db->fetchObject("\Oenstrom\User\User");
    if ($app->user->get("isBanned")) {
        $app->session->set("message", ["error", "Ditt konto är spärrat."]);
        $app->session->delete("user");
        $app->redirect("login");
    }
});


/**
 * Route for displaying user profile.
 */
$app->router->add("user/profile", function () use ($app) {
    if ($app->user->get("authority") === "admin") {
        $app->redirect("user/admin/profile");
    }
    $app->renderPage("login/profile", ["title" => "Min profil"]);
});


/**
 * Route for editing your profile.
 */
$app->router->add("user/edit", function () use ($app) {
    if (isset($_POST["user-form"])) {
        $userAuth = new \Oenstrom\User\UserAuth($app->db, $app->form);

        if ($userAuth->editUser($app->user, $_POST, ["email", "old_password"], [
                "email" => "unique:email#{$app->user->get("email")},email:",
                "old_password" => "password:{$app->user->get("id")}",
                "new_password" => "same:re_password"
        ])) {
            $app->session->set("message", ["success", "Profilen har uppdaterats."]);
        }
        $app->redirect("user/edit");
    }

    $app->renderPage("login/edit-user", ["title" => "Redigera profil", "user" => $app->user]);
});




/**
 * Route effecting all admin routes.
 */
$app->router->add("user/admin/**", function () use ($app) {
    if ($app->user->get("authority") !== "admin") {
        $app->redirect("user/profile");
    }
    $app->view->add("admin/nav", ["region" => "before-main"], "before-main", 0);
});


$app->router->add("user/admin/profile", function () use ($app) {
    $app->renderPage("login/profile", ["title" => "Min profil"]);
});


/**
 * Route for adding a new user, as admin.
 */
$app->router->add("user/admin/new", function () use ($app) {
    if (isset($_POST["user-form"])) {
        if (!$app->form->isFilled($_POST, ["username", "email", "password", "re_password", "authority"])) {
            $app->redirect("register");
        }
        $valid = ($app->form->validate($_POST, [
            "username" => "unique:username",
            "email" => "unique:email,email:",
            "password" => "same:re_password"
        ]));
        if (!$valid) {
            $app->redirect("register");
        }
        $userAuth = new \Oenstrom\User\UserAuth($app->db, $app->form);
        $userAuth->addUser($_POST);
        $app->session->set("message", ["success", "Ditt konto har skapats."]);
    }

    $app->renderPage("view/register", ["title" => "Registrera användare"]);
});


/**
 * Route for displaying users.
 */
$displayUsers = function ($search = ":all", $order = "username:asc", $page = 1, $hits = 4) use ($app) {
    if (isset($_POST["search"])) {
        $app->redirect("user/admin/users/{$_POST["search"]}/$order/1/$hits");
    }
    $userAuth = new \Oenstrom\User\UserAuth($app->db, $app->form);
    $res = $userAuth->displayUsers($search, $order, $page, $hits);

    $app->renderPage("login/user-table", [
        "title" => "Alla medlemmar",
        "users" => $res["users"],
        "route" => $res["route"],
        "nrOfPages" => $res["nrOfPages"],
    ], "admin");
};
$app->router->add("user/admin/users", $displayUsers);
$app->router->add("user/admin/users/{search}/{order}/{page}/{hits}", $displayUsers);


/**
 * Route for editing an user as admin.
 */
$app->router->add("user/admin/edit/{username}", function ($username) use ($app) {
    $app->db->execute("SELECT * FROM anax_users WHERE username = :username;", [":username" => $username]);
    $user = $app->db->fetchObject("\Oenstrom\User\User");

    if (isset($_POST["user-form"])) {
        $userAuth = new \Oenstrom\User\UserAuth($app->db, $app->form);
        $userAuth->editUser($user, $_POST, ["username", "email"], [
                "username" => "unique:username#{$user->get("username")}",
                "email" => "unique:email#{$user->get("email")},email:",
                "new_password" => "same:re_password"
        ]);
        $app->redirect("user/admin/edit/{$user->get("username")}");
    }

    $app->renderPage("login/edit-user", ["title" => "Redigera en användare", "user" => $user]);
});


/**
 * Route for removing an user.
 */
$app->router->add("user/admin/remove/{username}", function ($username) use ($app) {
    $userAuth = new \Oenstrom\User\UserAuth($app->db, $app->form);
    $userAuth->removeUser($username, $app->user->get("username"))
        ? $app->redirect("user/admin/users")
        : $app->redirect("user/admin/edit/$username");
});


/**
 * Route for blocking or unblocking an user.
 */
$app->router->add("user/admin/block/{username}", function ($username) use ($app) {
    $userAuth = new \Oenstrom\User\UserAuth($app->db, $app->form);
    $userAuth->handleBlock($username, $app->user->get("username"));
    $app->redirect("user/admin/edit/$username");
});


/**
 * Route for all admin content routes.
 */
$app->router->add("user/admin/content/**", function () use ($app) {
    $app->contentDao = new \Oenstrom\Content\ContentDao($app->db);
});


/**
 * Route for admin content overview.
 */
$app->router->add("user/admin/content/overview/{status}", function ($status) use ($app) {
    $allContent = $app->contentDao->getAll("all", $status);
    $title = $status === "published" ? "Publicerade" : ($status === "nonpublished" ? "Opublicerade" : "Borttagna");
    $app->renderPage("admin/overview", ["title" => $title, "content" => $allContent]);
});


/**
 * Route for creating content.
 */
$app->router->add("user/admin/content/create", function () use ($app) {
    if (isset($_POST["create"])) {
        $id = $app->contentDao->create($app->request->getPost("title"));
        $app->redirect("user/admin/content/edit/$id");
    }
    $app->renderPage("admin/create", ["title" => "Skapa innehåll"]);
});


/**
 * Route for editing content.
 */
$app->router->add("user/admin/content/edit/{id}", function ($id) use ($app) {
    $contentObj = $app->contentDao->getOne("\Oenstrom\Content\Content", $id);
    if (isset($_POST["edit"])) {
        $app->contentDao->update($_POST, $contentObj);
    }
    $app->renderPage("admin/edit", ["title" => "Redigera innehåll", "content" => $contentObj]);
});


/**
 * Route for deleting content.
 */
$app->router->add("user/admin/content/delete/{id}", function ($id) use ($app) {
    $app->contentDao->toggleDeleted($id);
    $app->redirect("user/admin/content/edit/$id");
});
