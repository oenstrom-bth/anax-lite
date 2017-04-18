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

    $data = ["title" => "Logga in"];
    $app->view->add("view/layout", $data, "layout");

    $app->view->add("view/flash", ["region" => "flash"], "flash", 0);
    $app->view->add("login/login", ["region" => "main"], "main", 0);
    $app->view->add("view/footer", ["region" => "footer"], "footer", 0);

    $body = $app->view->renderBuffered("layout");
    $app->response->setBody($body)->send();
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

    $data = ["title" => "Registrera användare"];
    $app->view->add("view/layout", $data, "layout");

    $app->view->add("view/flash", ["region" => "flash"], "flash", 0);
    $app->view->add("view/register", ["region" => "main"], "main", 0);
    $app->view->add("view/footer", ["region" => "footer"], "footer", 0);

    $body = $app->view->renderBuffered("layout");
    $app->response->setBody($body)->send();
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
    $data = ["title" => "Min profil"];
    $app->view->add("view/layout", $data, "layout");

    $app->view->add("view/flash", ["region" => "flash"], "flash", 0);
    $app->view->add("login/profile", ["region" => "main"], "main", 0);
    $app->view->add("view/footer", ["region" => "footer"], "footer", 0);

    $body = $app->view->renderBuffered("layout");
    $app->response->setBody($body)->send();
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

    $data = ["title" => "Redigera min profil"];
    $app->view->add("view/layout", $data, "layout");

    $app->view->add("view/flash", ["region" => "flash"], "flash", 0);
    $app->view->add("login/edit-user", ["region" => "main", "user" => $app->user], "main", 0);
    $app->view->add("view/footer", ["region" => "footer"], "footer", 0);

    $body = $app->view->renderBuffered("layout");
    $app->response->setBody($body)->send();
});


/**
 * Route effecting all admin routes.
 */
$app->router->add("user/admin/**", function () use ($app) {
    if ($app->user->get("authority") !== "admin") {
        $app->redirect("user/profile");
    }
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

    $data = ["title" => "Registrera användare"];
    $app->view->add("view/layout", $data, "layout");

    $app->view->add("view/flash", ["region" => "flash"], "flash", 0);
    $app->view->add("view/register", ["region" => "main"], "main", 0);
    $app->view->add("view/footer", ["region" => "footer"], "footer", 0);

    $body = $app->view->renderBuffered("layout");
    $app->response->setBody($body)->send();
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

    $data = ["title" => "Alla medlemmar"];
    $app->view->add("view/layout", $data, "layout");

    $app->view->add("view/flash", ["region" => "flash"], "flash", 0);
    $app->view->add("login/user-table", ["region" => "main", "users" => $res["users"], "route" => $res["route"], "nrOfPages" => $res["nrOfPages"]], "main", 0);
    $app->view->add("view/footer", ["region" => "footer"], "footer", 0);

    $body = $app->view->renderBuffered("layout");
    $app->response->setBody($body)->send();
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

    $data = ["title" => "Redigera en användare"];
    $app->view->add("view/layout", $data, "layout");

    $app->view->add("view/flash", ["region" => "flash"], "flash", 0);
    $app->view->add("login/edit-user", ["region" => "main", "user" => $user], "main", 0);
    $app->view->add("view/footer", ["region" => "footer"], "footer", 0);

    $body = $app->view->renderBuffered("layout");
    $app->response->setBody($body)->send();
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