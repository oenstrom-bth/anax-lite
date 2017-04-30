<?php

namespace Oenstrom\User;

/**
 * Class for talking to the user table.
 */
class UserAuth
{
    /**
     * @var Database  $db database object.
     * @var Form      $form form validation object.
     */
    private static $db;
    private static $form;


    /**
     * Constructor creating a object for accessing user info.
     *
     * @param Database $db Database object.
     * @param Form $form Form object.
     */
    public function __construct($db, $form)
    {
        self::$db = $db;
        self::$form = $form;
    }


    /**
     * Login an user.
     *
     * @param string $username The username to use for login.
     * @param string $password The password to use for login.
     * @return bool|int False if incorrect password or id of the user if correct password.
     */
    public function login($username, $password)
    {
        self::$db->connect();
        $user = self::$db->executeFetchAll("SELECT * FROM anax_users WHERE username = :username;", [":username" => $username]);
        if (count($user) !== 1 || !password_verify($password, $user[0]->password)) {
            return false;
        }
        return $user[0]->id;
    }


    /**
     * Add a new user to the database.
     *
     * @param array $fields POST data.
     *
     ** @return bool Query executed correctly or not.
     */
    public function addUser($fields)
    {
        $authority = isset($fields["authority"]) ? $fields["authority"] : "user";
        return self::$db->execute(
            "INSERT INTO anax_users(authority, username, password, email) VALUES(:authority, :username, :password, :email);",
            [
                ":authority" => $authority,
                ":username" => $fields["username"],
                ":password" => password_hash($fields["password"], PASSWORD_DEFAULT),
                ":email" =>    $fields["email"]
            ]
        );
    }


    /**
     * Edit an user.
     *
     * @param object $user The user to edit.
     * @param array $fields POST data.
     * @param array $required The required fields.
     * @param array $validation The array to use in validation.
     *
     * @return bool Query executed correctly or not.
     */
    public function editUser($user, $fields, $required, $validation)
    {
        if (!self::$form->isFilled($fields, $required)) {
            return false;
        }
        if (!self::$form->validate($fields, $validation)) {
            return false;
        }

        $user->edit($fields);
        $res = self::$db->execute(
            "UPDATE anax_users
                SET
                    authority = :authority,
                    username = :username,
                    password = :password,
                    firstname = :firstname,
                    lastname = :lastname,
                    email = :email,
                    birthday = :birthday,
                    bio = :bio,
                    isBanned = :isBanned
                WHERE
                    id = :id;",
            [
                ":authority" => $user->get("authority"),
                ":username"  => $user->get("username"),
                ":password"  => $user->get("password"),
                ":firstname" => $user->get("firstname"),
                ":lastname"  => $user->get("lastname"),
                ":email"     => $user->get("email"),
                ":birthday"  => $user->get("birthday"),
                ":bio"       => $user->get("bio"),
                ":isBanned"  => $user->get("isBanned"),
                ":id"        => $user->get("id"),
            ]
        );
        if ($res) {
            $_SESSION["message"] = ["success", "Profilen har uppdaterats."];
            return true;
        } else {
            $_SESSION["message"] = ["error", "Något gick fel. Försök igen."];
            return false;
        }
    }


    /**
     * Remove an user.
     *
     * @param string $username Username of the user to remove.
     * @param string $currentUsername Username of the user removing.
     *
     * @return bool Query executed correctly or not.
     */
    public function removeUser($username, $currentUsername)
    {
        if ($username === $currentUsername) {
            $_SESSION["message"] = ["error", "Du kan inte ta bort ditt egna konto."];
            return false;
        }
        $res = self::$db->execute("DELETE FROM anax_users WHERE username = :username LIMIT 1;", [":username" => $username]);
        if ($res) {
            $_SESSION["message"] = ["success", "Medlemmen har tagits bort."];
            return true;
        } else {
            $_SESSION["message"] = ["error", "Något gick fel. Försök igen."];
            return false;
        }
    }


    /**
     * Handle blocking and unblocking of an user.
     *
     * @param string $username The username to block.
     * @param string $currentUsername The username of the blocker.
     *
     * @return bool Query executed correctly or not.
     */
    public function handleBlock($username, $currentUsername)
    {
        if ($username === $currentUsername) {
            $_SESSION["message"] = ["error", "Du kan inte blockera/avblockera ditt egna konto."];
            return false;
        }
        $res = self::$db->execute(
            "UPDATE anax_users SET isBanned =
            CASE
                WHEN isBanned = false THEN true
                ELSE false
            END
            WHERE username = :username;",
            [":username" => $username]
        );
        if ($res) {
            $_SESSION["message"] = ["success", "Kontots blockeringsstatus har ändrats."];
        } else {
            $_SESSION["message"] = ["error", "Något gick fel. Försök igen."];
        }
        return $res;
    }


    /**
     * Get the users to display.
     *
     * @param string $search The search string.
     * @param string $order The order to display in.
     * @param numeric $page The page to display.
     * @param numeric $hits The number of items to display.
     *
     * @return array The users, the route and the number of pages.
     */
    public function displayUsers($search, $order, $page, $hits)
    {
        $page = $page < 1 ? 1 : $page;
        $orderBy = ["username", "email", "firstname", "lastname", "birthday", "authority", "isBanned"];
        list($order, $dir) = explode(":", $order);

        if (!in_array($dir, ["asc", "desc"]) || !in_array($order, $orderBy) || !is_numeric($page) || !is_numeric($hits)) {
            throw new Exception("Invalid search parameters.", 1);
        }

        $search = $search === ":all" ? "" : $search;
        $search = str_replace(["'", '"'], "", stripslashes(strip_tags($search)));
        self::$db->execute(
            "CREATE OR REPLACE VIEW search_anax_users AS
                SELECT * FROM anax_users
                    WHERE username LIKE '%$search%'
                       OR email LIKE '%$search%'
                       OR firstname LIKE '%$search%'
                       OR lastname LIKE '%$search%'
                       OR birthday LIKE '%$search%'
                       OR authority LIKE '%$search%';"
        );


        $route = [
            "search" => $search,
            "order" => $order,
            "dir" => $dir,
            "page" => $page,
            "hits" => $hits,
        ];
        $page = (($page - 1) * $hits);
        $users = self::$db->executeFetchAll("SELECT * FROM search_anax_users ORDER BY $order $dir, username $dir LIMIT $hits OFFSET $page;");
        $nrOfUsers = self::$db->executeFetchAll("SELECT COUNT(id) AS rows FROM search_anax_users;");
        $nrOfUsers = $nrOfUsers[0]->rows < 2 ? 1 : $nrOfUsers[0]->rows;
        $nrOfPages = ceil($nrOfUsers / $hits);

        return [
            "users" => $users,
            "route" => $route,
            "nrOfPages" => $nrOfPages,
        ];
    }
}
