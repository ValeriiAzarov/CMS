<?php
    include 'inc/config.php';
    include 'inc/filter_input_.php';
    include 'inc/init.php';
    include 'inc/header.php';

    $pages_model  = new PagesModel($mysqli);
    $message = "";
    $error_message = "";
    $displaymode = "view_pages";
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
                $result = $pages_model->add_page($url, $name, $content);
            }
            if ($result) {
                $message = "Page added successfully!";
            }
            else {
                $message = "Error occurred while adding page.";
            }
            break;
        case "delete": 
            $id = filter_input_("id", "");
            if (empty($id)) {
                break;
            }
            $pages_model->delete_page($id);
            break;
        case "edit": 
            $id =  filter_input_("id", "");
            if (empty($id)) {
                break;
            }
            $edit_page = $pages_model->get_page($id);
            if (empty($edit_page)) {
                $message = "Page not found with this ID.";
                break;
            }
            $news_name = $edit_page['name'];
            $news_url = $edit_page['url'];
            $news_content = $edit_page['content'];
            if (filter_input_("done", 0) != 1) {
                $displaymode = "edit_pages";
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
                $result = $pages_model->edit_page($url, $name, $content, $id);
            }
            if ($result) {
                $message = "Page changed!";
            }
            else { 
                $message = "Failed to change page.";
            }
            break;
        default:
            break;
    }

    switch ($displaymode) {
        case "view_pages":
            $pages = $pages_model->get_all_pages();
            ?>
            <main class="content">
                <div class="content-block">
                    <table class="table">
                        <tr>
                            <th>ID</th>
                            <th>URL</th>
                            <th>Page title</th>
                            <th>Published date</th>
                            <th>Actions</th>
                        </tr>
                        <?php foreach ($pages as $page) { ?>
                            <tr>
                                <td><?= $page["id"] ?></td>
                                <td><?= $page["url"]?></td>
                                <td><?= $page["name"]?></td>
                                <td><?= $page["published_date"]?></td>                            
                                <td>
                                    <a href="<?= HOST . 'cms/pages.php?action=edit&id=' . $page['id'] ?>">
                                        <input type="button" class="edit-button" value="Edit"/>
                                    </a>
                                    <a href="<?= HOST . 'cms/pages.php?action=delete&id=' . $page['id'] ?>">
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
                        <form action="<?= HOST . 'cms/'?>pages.php?action=add" method="post" class="login-form">
                            <div class="login-flex-block">
                                <span class="form-text">Page title:</span>
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
        case "edit_pages": ?>
            <main class="content">
                <div class="content-block">
                    <div class="form-block">
                        <form action="<?= HOST . 'cms/'?>pages.php?action=edit&id=<?=$id?>" method="post" class="login-form">
                            <div class="login-flex-block">
                                <span class="form-text">URL:</span>
                                <input class="login-input" type="text" max="100" name="url" value="<?=$news_url?>" required />
                            </div>
                            <div class="login-flex-block">
                                <span class="form-text">Page title:</span>
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
                                    <a href="<?= HOST . 'cms/'?>pages.php" ><input type="button" class="submit" value="BACK"></a>
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