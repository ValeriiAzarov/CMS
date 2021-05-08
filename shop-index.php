<?php
	$PAGE_TITLE = "MyDB - SQL";
	$PAGE_JS = Array();
	$PAGE_JS[] = 'assets/js/anim.js';	
	$PAGE_H1 = "MyDB - SQL";
	$PAGE_CSS = 'class="page_name_border_2"';
	
	include "include/filter_input_.php";
    include "init.php";

	$product_model = new ProductModel($mysqli);
    $section_model = new SectionModel($mysqli);
    $reviews_model = new ReviewsModel($mysqli);

    $id_product = filter_input_("id_product", NULL);
    $id_section = filter_input_("id_section", 1);
    
    $all_products = null;
    $product = null;

    $name = trim(filter_input_('name', ''));
    $email = trim(filter_input_('email', ''));
    $comment = trim(filter_input_('comment', ''));

    function check() {
        $filter = filter_input_('hidden_input', '');
        if ($filter == 'first') { 
            return true;
        }
        return false;
    }

    if (is_null($id_product)) {
        $sections = $section_model->get_all_sections();
        foreach ($sections as $section) {
            if ($id_section === $section['id']) {
                $all_products = $product_model->get_products_by_section($id_section);
            }
        }
    }
    else {
        if (is_numeric($id_product)) {
            $product = $product_model->get_product_by_id($id_product);
        }
    }

    if (check()) {
        $reviews_model->set_review($id_product, $name, $email, $comment);
    }

	include "include/header.php";
?>    
<div class="page_info">
	<div id="topics">
		<div>
            <div class="products">
                <?php if (is_null($id_product)) {                    
                        foreach ($sections as $section) { ?>
                            <a href="<?= HOST . "shop-index.php?id_section=".$section['id']?>" class="buy-item"><?=$section['name']?></a> <?php
                        }                    
                        if ($all_products != null) {
                            foreach ($all_products as $product) { ?>
                                <div class="product">
                                    <div class="item-name"><?= $product['name'] ?></div>
                                    <img src="<?= $product['image'] ?>" alt="img">
                                    <div class="description">
                                        <div style="font-size: 14px; font-weight: bold;">Price: <a style="color: green; font-size: 14px; font-weight: bold;">$<?= $product['price'] ?></a></div>
                                        <div>Articles: <?= $product['articles'] ?></div>                       
                                        <div class="details">
                                            <a href="<?= HOST ."shop-index.php?id_product=".$product['id']?>" class="buy-item more">More..</a>
                                        </div>
                                    </div>
                                </div> <?php
                            }
                        }
                    }
                    else {
                        if (is_null($product)) { ?>
                            <a href="<?= HOST ."shop-index.php"?>" class="buy-item more">Back</a>
                            <div>No such item!</div> <?php
                        }
                        else {
                            $product_model->add_view($id_product); ?>   
                            <a href="<?= HOST ."shop-index.php?id_section=".$product['id_section']?>" class="buy-item more">Back</a> 
                            <div class="product">
                                <div class="item-name"><?= $product['name'] ?></div>
                                <img src="<?= $product['image'] ?>" alt="img"> 
                                <div class="description">
                                    <div style="font-size: 14px; font-weight: bold;">Price: <a style="color: green; font-size: 14px; font-weight: bold;">$<?= $product['price'] ?></a></div>
                                    <div>Articles: <?= $product['articles'] ?></div>                               
                                    <?php $params = $product_model->get_params_by_id($id_product);
                                    if (!empty($params)) {
                                        foreach ($params as $param) { ?>
                                            <div><?= $param['name'] . ": " . $param['value'] ?></div>
                                        <?php }
                                    } ?> 
                                    <div class="details">
                                        <input type="button" value="Add to card" class="buy-item more">
                                    </div>
                                </div>             
                            </div> 
                            <?php 
                            $views = $product_model->get_day_views_by_id($id_product); ?>
                            <div style="text-align: left; color: #000000;">Views per day: <?= $views[0]['views'] ?></div>
                            <div style="text-align: left; color: #000000;">Views per week: <?= $product_model->get_views_by_time_period("CURDATE() - INTERVAL 1 WEEK", $id_product) ?></div>
                            <div style="text-align: left; color: #000000;">Views per month: <?= $product_model->get_views_by_time_period("CURDATE() - INTERVAL 1 MONTH", $id_product) ?></div>
                            <form action="" name="review" method="POST"  class="form">
                                <input type="hidden" name="hidden_input" value="first">
                                <div>
                                    Input name:
                                    <input name="name" id="name" type="text" required>
                                </div>
                                <div>
                                    Input email:
                                    <input name="email" id="email" type="email" required>
                                </div>
                                <div>
                                    Write comment:
                                </div>
                                <div>
                                    <textarea maxlength="200" required class="area" name="comment"></textarea>
                                </div>
                                <div class="block">
                                    <input type="submit" value="Submit" class="buy-item more" style="width: 150px;">
                                </div>
                            </form>                        
                            <?php  
                                $reviews = $reviews_model->get_reviews($id_product);
                                if (count($reviews) > 0) { ?>
                                    <div style="font-size: 28px; font-weight: bold; text-align: center;">Reviews</div>
                                <?php } ?>
                                <?php
                                foreach ($reviews as $review) { ?>
                                    <div class="comment">
                                        <div style="font-weight: bold;">User: <a style="font-weight: normal;"><?= $review['name'] ?></a></div>
                                        <div style="font-weight: bold;">Email: <a style="font-weight: normal;" href="mailto:<?= $review['email'] ?>"><?= $review['email'] ?></a></div>
                                        <div style="font-weight: bold;">Comment: <a style="font-weight: normal;"><?= $review['comment'] ?></a></div>
                                    </div>
                        <?php }
                        }
                    }
                ?>
            </div>
        </div>
	</div>
</div>

<?php
	include "include/footer.php";
?>