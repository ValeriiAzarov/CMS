<?php
    include 'inc/config.php';
    include 'inc/filter_input_.php';
    include 'inc/init.php';
    include 'inc/header.php';

    $section_model = new SectionModel($mysqli);
    $message = "";
    $error_message = "";
    $view_mode = "view_sections";
    $action = filter_input_("action", "");

    switch ($action) {
        case "add": 
            if (filter_input_("done", 0) != 1) {
                break;
            }
            $name = filter_input_("name", "");
            if (empty($name)) {
                $error_message = "Fill in all the fields!";
                break;
            }
            else {
                $result = $section_model->add_section($name);
            }
            if ($result) {
                $message = "Section added successfully!";
            }
            else {
                $message = "Error occurred while adding section. It may already exist!";
            }
            break;
        case "delete": 
            $id = filter_input_("id", "");
            if (empty($id)) {
                break;
            }
            $result = $section_model->delete_section($id);
            if(!$result) {
                $message = "Failed to delete section. It contains a product!";
            }
            break;
        case "edit": 
            $id =  filter_input_("id", "");
            if (empty($id)) {
                break;
            }
            $section = $section_model->get_section($id);
            if (empty($section)) {
                $message = "Section not found with this ID.";
                break;
            }
            $section_name = $section['name'];
            if (filter_input_("done", 0) != 1) {
                $view_mode = "edit_section";
                break;
            }
            $name = filter_input_("name", "");
            if (empty($name)) {
                $error_message = "Fill in all the fields!";
                $view_mode = "edit_section";
                break;
            }
            else {
                $result = $section_model->edit_section($name,$id);
            }
            if ($result) {
                $message = "Section changed!";
            }
            else {
                $message = "Failed to change section.";
            }
            break;
        default: 
            break;
    }

    switch ($view_mode) {
        case "view_sections": 
            $sections = $section_model->get_all_sections();
            ?>
            <main class="content">
                <div class="content-block">
                    <table class="table">
                        <tr>
                            <th>ID</th>
                            <th>Section</th>
                            <th>Actions</th>
                        </tr>
                        <?php foreach ($sections as $section) { ?>
                            <tr>
                                <td><?= $section["id"] ?></td>
                                <td><?= $section["name"] ?></td>
                                <td>
                                    <a href="<?= HOST . 'cms/sections.php?action=edit&id=' . $section['id'] ?>">
                                        <input type="button" class="edit-button" value="Edit"/>
                                    </a>
                                    <a href="<?= HOST . 'cms/sections.php?action=delete&id=' . $section['id'] ?>">
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
                        <form action="<?= HOST . 'cms/'?>sections.php?action=add" method="post" class="login-form">
                            <div class="login-flex-block">
                                <span class="form-text">Section:</span>
                                <input class="login-input" type="text" max="50" name="name" required />
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
        case "edit_section": ?>
            <main class="content">
                <div class="content-block">
                    <div class="form-block">
                        <form action="<?=HOST.'cms/'?>sections.php?action=edit&id=<?=$id?>" method="post" class="login-form">
                            <div class="login-flex-block">
                                <span class="form-text">Name:</span>
                                <input class="login-input" type="text" value="<?=$section_name?>" name="name" required />
                            </div>
                            <div class="login-flex-block">
                                <span class="login-error"><?=$error_message?></span>
                            </div>
                            <div class="login-flex-block">
                                <div class="buttons-block">
                                    <input type="submit" class="submit" value="EDIT">
                                    <a href="<?= HOST . 'cms/'?>sections.php" ><input type="button" class="submit" value="BACK"></a>
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