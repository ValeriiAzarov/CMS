<?php
    include 'inc/config.php';
    include 'inc/filter_input_.php';
    include 'inc/init.php';
    include 'inc/header.php';

    $user_model = new UserModel($mysqli);
    $message = "";
    $error_message = "";
    $view_mode = "view_users";
    $action = filter_input_("action", "");

    switch ($action) {
        case "add": 
            if (filter_input_("done", 0) != 1) {
                break;
            }
            $name = filter_input_("name", ""); 
            $login = filter_input_("login", ""); 
            $password = filter_input_("password", ""); 
            if ($name == "" || $login == "" || $password == "") {
                $error_message = "Fill in all the fields!";
                break;
            }
            else {
                $result = $user_model->add_user($name, $login, $password);
            }
            if ($result) {
                $message = "User added successfully!";
            }
            else {
                $message = "Error occurred while adding user.";
            }
            break;
        case "delete": 
            $id = filter_input_("id", ""); 
            if (empty($id)) {
                break;
            }
            if ($user_session->get_user_id() == $id) {
                $message = "Can't delete the active user!";
                break;
            }
            $user_model->delete_user($id);
            break;
        case "edit": 
            $id = filter_input_("id", ""); 
            if (empty($id)) {
                break;
            }
            $user = $user_model->get_user($id);
            if (empty($user)) {
                $message = "User not found with this ID.";
                break;
            }
            $user_name = $user['name'];
            $user_login = $user['login'];
            if (filter_input_("done", "") != 1) {
                $view_mode = "edit_user";
                break;
            }
            $name = filter_input_("name", ""); 
            $login = filter_input_("login", ""); 
            $password = filter_input_("password", ""); 
            if ($name == "" || $login == "" || $password == "") {
                $error_message = "Fill in all the fields!";
                $view = "edit_user";
                break;
            }
            else {
                $result = $user_model->edit_user($name, $login, $password, $id);
            }
            if ($result) {
                $message = "User changed!";
            }
            else {
                $message = "Failed to change user.";
            }
            break;
        default:
            break;
    }

    switch ($view_mode) {
        case "view_users":
                $users = $user_model->get_all_users();
                ?>
                <main class="content">
                    <div class="content-block">
                        <table class="table">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Login</th>
                                <th>Actions</th>
                            </tr>
                            <?php foreach ($users as $user) { ?>
                                <tr>
                                    <td><?= $user["id"] ?></td>
                                    <td><?= $user["name"] ?></td>
                                    <td><?= $user["login"] ?></td>
                                    <td>
                                        <a href="<?= HOST . 'cms/users.php?action=edit&id=' . $user['id'] ?>">
                                            <input type="button" class="edit-button" value="Edit"/>
                                        </a>
                                        <a href="<?= HOST . 'cms/users.php?action=delete&id=' . $user['id'] ?>">
                                            <input type="button" class="delete-button" value="Delete"/>
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                    <div class="content-block">
                        <span class="content-text"><?= $message ?></span>
                    </div>
                    <div class="content-block">
                        <div class="form-block">
                        <form action="<?= HOST . 'cms/'?>users.php?action=add" method="post" class="login-form">
                            <div class="login-flex-block">
                                <span class="form-text">Name:</span>
                                <input class="login-input" type="text" max="50" name="name" required />
                            </div>
                            <div class="login-flex-block">
                                <span class="form-text">Login:</span>
                                <input class="login-input" type="text" max="100" name="login" required />
                            </div>
                            <div class="login-flex-block">
                                <span class="form-text">Password:</span>
                                <input class="login-input" type="password" max="100" name="password" required />
                            </div>
                            <div class="login-flex-block">
                                <span class="login-error"><?=$error_message?></span>
                            </div>
                            <div class="login-flex-block">
                                <input type="submit" class="submit" value="ADD">
                            </div>
                            <input type="hidden" value="1" name="done"/>
                        </form>
                        </div>
                    </div>
                </main>
                <?php
            break;
        case "edit_user": ?>
                <main class="content">
                            <div class="content-block">
                                <div class="form-block">
                                <form action="<?= HOST . 'cms/'?>users.php?action=edit&id=<?=$id?>" method="post" class="login-form">
                                    <div class="login-flex-block">
                                        <span class="form-text">Name:</span>
                                        <input class="login-input" type="text" value="<?=$user_name?>" name="name" required />
                                    </div>
                                    <div class="login-flex-block">
                                        <span class="form-text">Login:</span>
                                        <input class="login-input" type="text" value="<?=$user_login?>" name="login" required />
                                    </div>
                                    <div class="login-flex-block">
                                        <span class="form-text">Password:</span>
                                        <input class="login-input" type="password" name="password" required />
                                    </div>
                                    <div class="login-flex-block">
                                        <span class="login-error"><?=$error_message?></span>
                                    </div>
                                    <div class="login-flex-block">
                                        <div class="buttons-block">
                                            <input type="submit" class="submit" value="EDIT">
                                            <a href="<?= HOST . 'cms/'?>users.php" ><input type="button" class="submit" value="BACK"></a>
                                        </div>
                                    </div>
                                    <input type="hidden" value="1" name="done"/>
                                </form>
                                </div>
                            </div>
                        </main>
                    <?php
                    break;
        default: 
            break;
    }
    include 'inc/footer.php';

