<div class="col-12">
    <h1>Medlemmar</h1>
    <? if ($app->session->has("message")) : ?>
        <p class="<?= $app->session->get("message")[0] ?>"><?= $app->session->getOnce("message")[1] ?></p>
    <? endif; ?>
    <form method="POST" class="form">
        <div class="form-group full-width center">
            <input type="text" name="search" autofocus>
        </div>
    </form>
    <p>Antal per sida:
        <a href="<?= $this->url("user/admin/users/{$route["search"]}/{$route["order"]}:{$route["dir"]}/{$route["page"]}/2") ?>">2</a>
        <a href="<?= $this->url("user/admin/users/{$route["search"]}/{$route["order"]}:{$route["dir"]}/{$route["page"]}/4") ?>">4</a>
        <a href="<?= $this->url("user/admin/users/{$route["search"]}/{$route["order"]}:{$route["dir"]}/{$route["page"]}/8") ?>">8</a>
    </p>
    <div class="table-wrapper">
        <table class="table center">
            <thead>
                <tr>
                    <th></th>
                    <th>Användarnamn
                        <div class="sort-wrapper">
                            <a class="sort-icon" href="<?= $this->url("user/admin/users/{$route["search"]}/username:asc/{$route["page"]}/{$route["hits"]}") ?>">
                                <i class="material-icons">arrow_drop_up</i>
                            </a>
                            <a class="sort-icon" href="<?= $this->url("user/admin/users/{$route["search"]}/username:desc/{$route["page"]}/{$route["hits"]}") ?>">
                                <i class="material-icons">arrow_drop_down</i>
                            </a>
                        </div>
                    </th>
                    <th>E-post
                        <div class="sort-wrapper">
                            <a class="sort-icon" href="<?= $this->url("user/admin/users/{$route["search"]}/email:asc/{$route["page"]}/{$route["hits"]}") ?>">
                                <i class="material-icons">arrow_drop_up</i>
                            </a>
                            <a class="sort-icon" href="<?= $this->url("user/admin/users/{$route["search"]}/email:desc/{$route["page"]}/{$route["hits"]}") ?>">
                                <i class="material-icons">arrow_drop_down</i>
                            </a>
                        </div>
                    </th>
                    <th>Förnamn
                        <div class="sort-wrapper">
                            <a class="sort-icon" href="<?= $this->url("user/admin/users/{$route["search"]}/firstname:asc/{$route["page"]}/{$route["hits"]}") ?>">
                                <i class="material-icons">arrow_drop_up</i>
                            </a>
                            <a class="sort-icon" href="<?= $this->url("user/admin/users/{$route["search"]}/firstname:desc/{$route["page"]}/{$route["hits"]}") ?>">
                                <i class="material-icons">arrow_drop_down</i>
                            </a>
                        </div>
                    </th>
                    <th>Efternamn
                        <div class="sort-wrapper">
                            <a class="sort-icon" href="<?= $this->url("user/admin/users/{$route["search"]}/lastname:asc/{$route["page"]}/{$route["hits"]}") ?>">
                                <i class="material-icons">arrow_drop_up</i>
                            </a>
                            <a class="sort-icon" href="<?= $this->url("user/admin/users/{$route["search"]}/lastname:desc/{$route["page"]}/{$route["hits"]}") ?>">
                                <i class="material-icons">arrow_drop_down</i>
                            </a>
                        </div>
                    </th>
                    <th>Födelsedag
                        <div class="sort-wrapper">
                            <a class="sort-icon" href="<?= $this->url("user/admin/users/{$route["search"]}/birthday:asc/{$route["page"]}/{$route["hits"]}") ?>">
                                <i class="material-icons">arrow_drop_up</i>
                            </a>
                            <a class="sort-icon" href="<?= $this->url("user/admin/users/{$route["search"]}/birthday:desc/{$route["page"]}/{$route["hits"]}") ?>">
                                <i class="material-icons">arrow_drop_down</i>
                            </a>
                        </div>
                    </th>
                    <th>Behörighet
                        <div class="sort-wrapper">
                            <a class="sort-icon" href="<?= $this->url("user/admin/users/{$route["search"]}/authority:asc/{$route["page"]}/{$route["hits"]}") ?>">
                                <i class="material-icons">arrow_drop_up</i>
                            </a>
                            <a class="sort-icon" href="<?= $this->url("user/admin/users/{$route["search"]}/authority:desc/{$route["page"]}/{$route["hits"]}") ?>">
                                <i class="material-icons">arrow_drop_down</i>
                            </a>
                        </div>
                    </th>
                    <th>Bannad
                        <div class="sort-wrapper">
                            <a class="sort-icon" href="<?= $this->url("user/admin/users/{$route["search"]}/isBanned:asc/{$route["page"]}/{$route["hits"]}") ?>">
                                <i class="material-icons">arrow_drop_up</i>
                            </a>
                            <a class="sort-icon" href="<?= $this->url("user/admin/users/{$route["search"]}/isBanned:desc/{$route["page"]}/{$route["hits"]}") ?>">
                                <i class="material-icons">arrow_drop_down</i>
                            </a>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
            <? foreach($users as $user) : ?>
                <tr>
                    <td><a href="<?= $this->url("user/admin/edit/{$user->username}") ?>"><i class="material-icons">edit</i></a></td>
                    <td><?= $user->username ?></td>
                    <td><?= $user->email ?></td>
                    <td><?= $user->firstname ?></td>
                    <td><?= $user->lastname ?></td>
                    <td><?= $user->birthday ?></td>
                    <td><?= $user->authority ?></td>
                    <td><?= $user->isBanned ? "Ja" : "Nej" ?></td>
                </tr>
            <? endforeach; ?>
            </tbody>
        </table>
    </div>
    <ul class="pagination">
        <? foreach (range(1, $nrOfPages) as $page) : ?>
            <li<?= $page == $route["page"] ? ' class="active"' : '' ?>>
                <a href="<?= $this->url("user/admin/users/{$route["search"]}/{$route["order"]}:{$route["dir"]}/{$page}/{$route["hits"]}") ?>">
                    <?= $page ?>
                </a>
            </li>
        <? endforeach; ?>
    </ul>
</div>
