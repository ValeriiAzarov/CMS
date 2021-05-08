<?php
    include 'inc/config.php';
    include 'inc/filter_input_.php';
    include 'inc/init.php';

    $user_session  = new UserSessions($mysqli);
    $message = "";

    if (!$user_session->check_user_session()) {
        header("Location: ". HOST ."cms/index.php");
        exit();
    }
    if (filter_input_("done", 0) == 1) {
        $login = filter_input_("login", "");
        $password = filter_input_("password","");
        if ($login == "" || $password == "") {
            $message = "Fill in all the fields!";
        }
        else if ($user_session->check_user_login($login, $password)) {
            $user_session->make_user_login();
            header("Location: ". HOST ."cms/index.php");
            exit();
        }
        else {
            $message = "Incorrect password or login.";
        }
    }
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8"/>
    <title>CMS | Valerii Azarov</title>
    <link rel="stylesheet" type="text/css" href="css/cms.css">
</head>
<body class="container">
<section class="main-block">
    <div class="form-login-block">
            <form action="authorization.php" class="login-form" method="post">
                <div class="login-flex-block">
                    <span class="form-text">Login:</span>
                    <input class="login-input" required type="text" name="login">
                </div>
                <div class="login-flex-block">
                    <span class="form-text">Password:</span>
                    <input class="login-input" required type="password" name="password">
                </div>
                <div class="login-flex-block">
                    <input type="submit" class="submit" value="Log in">
                </div>
                <div class="login-flex-block">
                    <span class="login-error"><?=$message?></span>
                </div>
                <input type="hidden" value="1" name="done">
            </form>
    </div>
</section>
</body>