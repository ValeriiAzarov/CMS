<?php
    include 'inc/config.php';
    include 'inc/filter_input_.php';
    include 'inc/init.php';
    include 'inc/header.php';

    $products_model = new ProductModel($mysqli);
    $section_model=  new SectionModel($mysqli);
    $message = "";
    $error_message = "";
    $view_mode = "view_products";
    $action = filter_input_("action", "");

    switch ($action) {
        case "add": 
            if (filter_input_("done", 0) != 1) {
                break;
            }
            $name = filter_input_("name", "");
            $price = filter_input_("price", "");
            $articles = filter_input_("articles", "");
            $image= filter_input_("image", "");
            $id_section = filter_input_("id_section", "");
            if ($name == "" || $price == "" || $articles =="" || $image =="" || $id_section=="") {
                $error_message = "Fill in all the fields!";
                break;
            }
            else {
                $result = $products_model->add_product($name, $price, $articles, $image, $id_section);
                if ($result) {
                    $message = "Product added successfully!";
                }
                else {
                    $message = "Error occurred while adding item.";
                }
                break;
            }
        case "delete": 
            $id = filter_input_("id", "");
            if (empty($id)) {
                break;
            }
            $product = $products_model->get_product_by_id($id);
            if (empty($product)) {
                $message = "There is no such item!";
            }
            else {
                $result = $products_model->delete_product($id);
                if (!$result) {
                    $message = "Failed to delete item.";
                }
            }
            break;
        case "edit": 
            $id = filter_input_("id", "");
            if (empty($id)) {
                break;
            }
            $edit_product =$products_model->get_product_by_id($id);
            if (empty($edit_product)) {
                $message = "Product not found with this ID.";
                break;
            }
            $name =  $edit_product['name'];
            $price = $edit_product['price'];
            $articles = $edit_product['articles'];
            $image = $edit_product['image'];
            if (filter_input_("done", 0) != 1) {
                $view_mode = "edit_product";
                break;
            }
            $name = filter_input_("name", "");
            $price = filter_input_("price", "");
            $articles = filter_input_("articles", "");
            $image = filter_input_("image", "");
            $id_section = filter_input_("id_section", "");
            if ($name == "" || $price == ""  || $articles =="" || $image == "" || $id_section== "") {
                $error_message = "Fill in all the fields!";
                break;
            }
            else {
                $result = $products_model->edit_product($name, $price, $articles, $image, $id_section, $id);
            }
            if ($result) {
                $message = "Item changed!";
            }
            else {
                $message = "Failed to change item.";
            }
            break;
        case "view_params": 
            $id = filter_input_("id", "");
            if (empty($id)) {
                break;
            }
            $product = $products_model->get_product_by_id($id);
            if (empty($product)) {
                $message = "Product not found with this ID.";
                break;
            }
            $view_mode = 'view_params';
        case "add_param": 
            $id =  filter_input_("id", "");
            if (empty($id)) {
                break;
            }
            $product = $products_model->get_product_by_id($id);
            if (empty($product)) {
                $message = "Product not found with this ID.";
                break;
            }
            $view_mode = 'view_params';
            if (filter_input_("done", 0) != 1) {
                break;
            }
            $param_name = filter_input_("param_name", "");
            $param_value = filter_input_("param_value", "");
            $sort = filter_input_("sort", ""); 
            if ($param_name == "" || $param_value == "" || $sort == "" ) {
                $error_message = "Fill in all the fields!";
                break;
            }
            else {
                $result = $products_model->add_param($param_name, $param_value, $sort, $id);
                if ($result) {
                    $message = "Parameter added successfully!";
                }
                else {
                    $message = "Error occurred while adding parameter.";
                }
            }
            break;
        case "delete_param": 
            $id = filter_input_("id", "");
            $param_id = filter_input_("param_id", "");
            $product = $products_model->get_product_by_id($id);
            if (empty($param_id)) {
                break;
            }
            else {
                $result = $products_model->delete_param($param_id);
                if (!$result) {
                    $message = "Failed to delete parameter.";
                }
            }
            if (!empty($product)) {
                $view_mode = "view_params";
            }
            break;
        case "views": 
            $id =  filter_input_("id", "");
            if (empty($id)) {
                break;
            }
            $product = $products_model->get_product_by_id($id);
            if (empty($product)) {
                $message = "Product not found with this ID.";
                break;
            }
            $view_mode = 'view_views';
        case "views_delete": 
            $id = filter_input_("id", "");
            $views_by_day_id = filter_input_("views_by_day_id", "");
            $product = $products_model->get_product_by_id($id);
            if (empty($views_by_day_id)) {
                break;
            }
            else {
                $result = $products_model->delete_views($views_by_day_id);
                if (!$result) {
                    $message = "Failed to delete views.";
                }
            }
            if (!empty($product)) {
                $view_mode = "view_views";
            }
            break;
        case "reset_views": 
            $id =  filter_input_("id", "");
            if (empty($id)) {
                break;
            }
            $product = $products_model->get_product_by_id($id);
            if (empty($product)) {
                $message = "Product not found with this ID.";
                break;
            }
            $view_mode = 'view_views';
            if (filter_input_("done", 0) != 1) {
                break;
            }
            $reset_days = filter_input_("reset_days", "");
            if ($reset_days == "") {
                $error_message = "Fill in all the fields!";
                break;
            }
            else {
                $result = $products_model->delete_views_by_time_period($reset_days, $id);
                if ($result) {
                    $message = "Views zeroed successfully!";
                }
                else {
                    $message = "Error occurred while adding views.";
                }
            }
            break;
        default: 
            break;
    }

    switch ($view_mode) {
        case "view_products": 
            $products = $products_model->get_all_products();
            $sections = $section_model->get_all_sections();
            ?>
            <main class="content">
                <div class="content-block">
                    <table class="table">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Articles</th>
                            <th>Image URL</th>
                            <th>Actions</th>
                        </tr>
                        <?php foreach ($products as $product) { ?>
                            <tr>
                                <td><?= $product["id"] ?></td>
                                <td><?= $product["name"] ?></td>
                                <td><?= $product["price"] ?></td>
                                <td><?= $product["articles"] ?></td>
                                <td><?= $product["image"] ?></td>
                                <td>
                                    <a href="<?= HOST . 'cms/products.php?action=edit&id=' . $product['id'] ?>">
                                        <input type="button" class="edit-button" value="Edit"/>
                                    </a>
                                    <a href="<?= HOST . 'cms/products.php?action=view_params&id=' . $product['id'] ?>">
                                        <input type="button" class="params-button" value="Parameters"/>
                                    </a>
                                    <a href="<?= HOST . 'cms/products.php?action=delete&id=' . $product['id'] ?>">
                                        <input type="button" class="delete-button" value="Delete"/>
                                    </a>
                                    <a href="<?= HOST . 'cms/products.php?action=views&id=' . $product['id'] ?>">
                                        <input type="button" class="views-button" value="Views"/>
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
                        <form  enctype="multipart/form-data" action="<?= HOST . 'cms/' ?>products.php?action=add" method="post" class="login-form">
                            <div class="login-flex-block">
                                <span class="form-text">Name:</span>
                                <input class="login-input" type="text" max="150" name="name" required />
                            </div>
                            <div class="login-flex-block">
                                <span class="form-text">Price:</span>
                                <input class="login-input" type="text" max="10" name="price" required />
                            </div>
                            <div class="login-flex-block">
                                <span class="form-text">Articles:</span>
                                <input class="login-input" type="text" max="50" name="articles" required />
                            </div>
                            <div class="login-flex-block">
                                <span class="form-text">Image URL:</span>
                                <input class="login-input" type="text" max="250" name="image" required />
                            </div>
                            <div class="login-flex-block">
                                <span class="form-text">Sections:</span>
                                <select type="text" name="id_section" required >
                                    <?php foreach($sections as $section) {
                                        echo '<option value="'.$section['id'].'" >'.$section['name'].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="login-flex-block">
                                <span class="login-error"><?=$error_message?></span>
                            </div>
                            <div class="login-flex-block">
                                <input type="submit" class="submit" value="ADD PRODUCT">
                            </div>
                            <input type="hidden" value="1" name="done"/>
                        </form>
                    </div>
                </div>
            </main>
            <?php
            break;
        case "edit_product": 
            $sections = $section_model->get_all_sections();?>
            <main class="content">
                <div class="content-block">
                    <div class="form-block">
                        <form enctype="multipart/form-data" action="<?= HOST . 'cms/'?>products.php?action=edit&id=<?=$id?>" method="post" class="login-form">
                            <div class="login-flex-block">
                                <span class="form-text">Name:</span>
                                <input class="login-input" type="text" max="150" name="name" value="<?=$name?>"  required />
                            </div>
                            <div class="login-flex-block">
                                <span class="form-text">Price:</span>
                                <input class="login-input" type="text" max="10" name="price" value="<?=$price?>" required />
                            </div>
                            <div class="login-flex-block">
                                <span class="form-text">Articles:</span>
                                <input class="login-input" type="text" max="50" name="articles" value="<?=$articles?>" required />
                            </div>                            
                            <div class="login-flex-block">
                                <span class="form-text">Image URL:</span>
                                <input class="login-input" type="text" max="250" name="image" value="<?=$image?>" required />
                            </div>
                            <div class="login-flex-block">
                                <span class="form-text">Sections:</span>
                                <select type="text" name="id_section" required >
                                    <?php
                                    foreach ($sections as $section) {
                                        $selected = ($section["id"] == $edit_product["id_section"])? 'selected':'';
                                        echo '<option value="'.$section['id'].'" '.$selected.'>'.$section['name'].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="login-flex-block">
                                <span class="login-error"><?=$error_message?></span>
                            </div>
                            <div class="login-flex-block">
                                <div class="buttons-block">
                                    <input type="submit" class="submit" value="EDIT">
                                    <a href="<?= HOST . 'cms/'?>products.php" ><input type="button" class="submit" value="BACK"></a>
                                </div>
                            </div>
                            <input type="hidden" value="1" name="done"/>
                        </form>
                    </div>
                </div>
            </main>
            <?php
            break;
        case "view_params": 
            $params = $products_model->get_params_by_id($id);
            ?>
            <main class="content">
                <div class="content-block">
                    <table class="table">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Value</th>
                            <th>Order</th>
                            <th>Actions</th>
                        </tr>
                        <?php foreach ($params as $param) { ?>
                            <tr>
                                <td><?= $param["id"] ?></td>
                                <td><?= $param["name"] ?></td>
                                <td><?= $param["value"] ?></td>
                                <td><?= $param["sort"] ?></td>
                                <td>
                                    <a href="<?= HOST . 'cms/products.php?action=delete_param&param_id=' . $param['id'].'&id='.$product['id']?>">
                                        <input type="button" class="delete-button" value="DELETE"/>
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
                        <form action="<?= HOST . 'cms/'?>products.php?action=add_param&id=<?=$id?>" method="post" class="login-form">
                            <div class="login-flex-block">
                                <span class="form-text">Name:</span>
                                <input class="login-input" type="text" max="70" name="param_name" required />
                            </div>
                            <div class="login-flex-block">
                                <span class="form-text">Value:</span>
                                <input class="login-input" type="text" max="100" name="param_value" required />
                            </div>
                            <div class="login-flex-block">
                                <span class="form-text">Priority:</span>
                                <input class="login-input" type="number" step="1" name="sort" required />
                            </div>
                            <div class="login-flex-block">
                                <span class="login-error"><?=$error_message?></span>
                            </div>
                            <div class="login-flex-block">
                                <div class="buttons-block">
                                    <input type="submit" class="submit" value="ADD">
                                    <a href="<?= HOST . 'cms/'?>products.php" ><input type="button" class="submit" value="BACK"></a>
                                </div>
                            </div>
                            <input type="hidden" value="1" name="done"/>
                        </form>
                    </div>
                </div>
            </main>
            <?php
            break;
        case "view_views": 
            $views = $products_model->get_all_views($id);
            ?>
            <main class="content">
                <div class="content-block">
                    <table class="table">
                        <tr>
                            <th>ID</th>
                            <th>Date</th>
                            <th>Quantity</th>
                            <th>Actions</th>
                        </tr>
                        <?php foreach ($views as $view) { ?>
                            <tr>
                                <td><?= $view["id"] ?></td>
                                <td><?= $view["date"] ?></td>
                                <td><?= $view["views"] ?></td>
                                <td>
                                    <a href="<?= HOST . 'cms/products.php?action=views_delete&views_by_day_id=' . $view['id'].'&id='.$product['id']?>">
                                        <input type="button" class="delete-button" value="DELETE"/>
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
                        <form action="<?= HOST . 'cms/'?>products.php?action=reset_views&id=<?=$id?>" method="post" class="login-form">
                            <div class="login-flex-block">
                                <span class="form-text">The number of days for which you need to reset views:</span>
                                <input class="login-input" type="number" min="0" step="1" name="reset_days" required />
                            </div>
                            <div class="login-flex-block">
                                <span class="login-error"><?=$error_message?></span>
                            </div>
                            <div class="login-flex-block">
                                <div class="buttons-block">
                                    <input type="submit" class="submit" value="RESET">
                                    <a href="<?=HOST.'cms/'?>products.php" ><input type="button" class="submit" value="BACK"></a>
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