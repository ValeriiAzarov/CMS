<?php
    include 'inc/config.php';
    include 'inc/filter_input_.php';
    include 'inc/init.php';
    include 'inc/header.php';

    $news_model  = new NewsModel($mysqli);
    $message = "";
    $error_message = "";
    $view_mode = "view_news";
    $action = filter_input_("action", "");

    switch ($action) {
        case "add": 
            if (filter_input_("done", 0) != 1) {
                break;
            }
            $name = filter_input_("name", "");
            $url = filter_input_("url", "");
            $content= filter_input_("content", "");
            if ($name == "" || $url == "" || $content == "") {
                $error_message = "Fill in all the fields!";
                break;
            }
            else {
                $result = $news_model->add_news($url, $name, $content);
            }
            if ($result) {
                $message = "News added successfully!";
            }
            else {
                $message = "Error occurred while adding news.";
            }
            break;
        case "delete":
            $id = filter_input_("id", "");
            if (empty($id)) {
                break;
            }
            $news_model->delete_news($id);
            break;
        case "edit": 
            $id = filter_input_("id", "");
            if (empty($id)) {
                break; 
            }
            $edit_news = $news_model->get_news($id);
            if (empty($edit_news)) {
                $message = "News not found with this ID.";
                break;
            }
            $news_name = $edit_news['name'];
            $news_url = $edit_news['url'];
            $news_content = $edit_news['content'];
            if (filter_input_("done", 0) != 1) {
                $view_mode = "edit_news";
                break;
            }
            $name = filter_input_("name", "");
            $url = filter_input_("url", "");
            $content= filter_input_("content", "");
            if ($name == "" || $url == "" || $content == "") {
                $error_message = "Fill in all the fields!";
                break;
            }
            else {
                $result = $news_model->edit_news($url, $name, $content, $id);
            }
            if ($result) {
                $message = "News changed!";
            }
            else {
                $message = "Failed to change news.";
            }
            break;
        default: 
            break;
    }

    switch ($view_mode) {
        case "view_news": 
            $news = $news_model->get_all_news();
            ?>
            <main class="content">
                <div class="content-block">
                    <table class="table">
                        <tr>
                            <th>ID</th>
                            <th>URL</th>
                            <th>News title</th>
                            <th>Published date</th>                        
                            <th>Actions</th>
                        </tr>
                        <?php foreach ($news as $one_news) { ?>
                            <tr>
                                <td><?= $one_news["id"] ?></td>
                                <td><?= $one_news["url"]?></td>
                                <td><?= $one_news["name"]?></td>
                                <td><?= $one_news["published_date"]?></td>                            
                                <td>
                                    <a href="<?= HOST . 'cms/news.php?action=edit&id=' . $one_news['id'] ?>">
                                        <input type="button" class="edit-button" value="Edit"/>
                                    </a>
                                    <a href="<?= HOST . 'cms/news.php?action=delete&id=' . $one_news['id'] ?>">
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
                        <form action="<?= HOST . 'cms/'?>news.php?action=add" method="post" class="login-form">
                            <div class="login-flex-block">
                                <span class="form-text">News title:</span>
                                <input class="login-input" type="text" max="100" name="name" required />
                            </div>
                            <div class="login-flex-block">
                                <span class="form-text">URL:</span>
                                <input class="login-input" type="text" max="100" name="url" required />
                            </div>
                            <div class="login-flex-block">
                                <span class="form-text">Content:</span>
                                <textarea class="login-input"  name="content" required></textarea>
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
        case "edit_news": ?>
            <main class="content">
                <div class="content-block">
                    <div class="form-block">
                        <form action="<?= HOST . 'cms/'?>news.php?action=edit&id=<?=$id?>" method="post" class="login-form">
                            <div class="login-flex-block">
                                <span class="form-text">URL:</span>
                                <input class="login-input" type="text" max="100" name="url" value="<?=$news_url?>" required />
                            </div>
                            <div class="login-flex-block">
                                <span class="form-text">News title:</span>
                                <input class="login-input" type="text" max="100" name="name" value="<?=$news_name?>" required />
                            </div>                        
                            <div class="login-flex-block">
                                <span class="form-text">Content:</span>
                                <textarea class="login-input"  name="content" required><?=$news_content?></textarea>
                            </div>
                            <div class="login-flex-block">
                                <span class="login-error"><?=$error_message?></span>
                            </div>
                            <div class="login-flex-block">
                                <div class="buttons-block">
                                    <input type="submit" class="submit" value="EDIT">
                                    <a href="<?= HOST . 'cms/'?>news.php" ><input type="button" class="submit" value="BACK"></a>
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
