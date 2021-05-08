<?php
    $user_session = new UserSessions($mysqli);

    if ($user_session->check_user_session()) {
        header("Location: ". HOST ."cms/authorization.php");
        exit();
    }
    if (filter_input_("logout", 0) == 1) {
        $user_session->logout();
        header("Location: ". HOST ."cms/authorization.php");
        exit();
    }

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8"/>
    <title>CMS | Valerii Azarov</title>
    <link rel="stylesheet" type="text/css" href="<?= HOST . 'cms/css/cms.css'?>"> <?
        if (isset($CSS)) {
            foreach ($CSS as $value) { ?>
                <link rel="stylesheet" type="text/css" href="<?= HOST .'cms/css/'. $value ?>"> <?
            }
        }
        if (isset($JS)) {
            foreach ($JS as $value) { ?>
                <script src="<?= HOST . $value ?>"></script> <?
            }
        } ?>
</head>
<body class="container">
    <header>
        <div class="navigation">
            <a href="<?= HOST . 'cms/users.php'?>"><div class="navigation-block">Users</div></a>
            <a href="<?= HOST . 'cms/sections.php'?>"><div class="navigation-block">Sections</div></a>
            <a href="<?= HOST . 'cms/products.php'?>"><div class="navigation-block">Products</div></a>
            <a href="<?= HOST . 'cms/reviews.php'?>"><div class="navigation-block">Сomments</div></a>
            <a href="<?= HOST . 'cms/news.php'?>"><div class="navigation-block">News</div></a>
            <a href="<?= HOST . 'cms/pages.php'?>"><div class="navigation-block">Pages</div></a>
            <a href="index.php?logout=1"><div class="navigation-block">Log out</div></a>
        </div>
</header>