<?php
    include 'inc/config.php';
    include 'inc/filter_input_.php';
    include 'inc/init.php';
    include 'inc/header.php';

    $reviews_model = new ReviewsModel($mysqli);
    $view_mode = "view_comment";
    $action = filter_input_("action", "");

    if ($action == "delete") {
        $reviews_model->delete_review(filter_input_("id", ""));
    }

    if ($view_mode =="view_comment") {
        $reviews = $reviews_model->get_all_reviews();
?>

<main class="content">
    <div class="content-block">
        <table class="table">
            <tr>
                <th>ID</th>
                <th>Сomment</th>
                <th>ID product</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($reviews as $review) { ?>
                <tr>
                    <td><?= $review["id"] ?></td>
                    <td><?= $review["comment"] ?></td>
                    <td><a href="<?= HOST . "shop.php?id_product=" . $review['id_product']?>" target="_blank"><?=$review['id_product']?></a></td>
                    <td>
                        <a href="<?= HOST . 'cms/reviews.php?action=delete&id=' . $review['id'] ?>">
                           <input type="button" class="delete-button" value="Delete"/>
                        </a>
                    </td>
                </tr>
            <?php }
        }?>
        </table>
    </div>
</main>
<?php
    include 'inc/footer.php';