<?php
	$PAGE_TITLE = "PAGES";
	$PAGE_JS = Array();
	$PAGE_JS[] = 'assets/js/anim.js';
	$PAGE_H1 = "PAGES";
	$PAGE_CSS = 'class="page_name_border_1"';

	include "cms/classes/PagesModel.class.php";
	include "include/filter_input_.php";
    include "init.php";

	$pages_model = new PagesModel($mysqli);
    $url = filter_input_("url", "");

	include "include/header.php";
?>    
<div class="page_info">
	<div id="topics">
	<?php if (empty($url)) {
        $pages = $pages_model->get_all_pages();
        if (!empty($pages)) { ?>
			<ol class="rounded"> <?php
            foreach ($pages as $page) { ?> 
				<li><a href="<?= HOST . "pages-index.php?url=".$page['url']?>"><?=$page['name']?></a></li> <?php
            } ?>
            </ol> <?php
        } 
	} 
	else {
		 $page = $pages_model->get_page_url($url);
		 if (empty($page)) { ?>
			 <div>
			 	<a href="<?= HOST . "pages-index.php"?>" class="back">Back</a>
				<div>Такой новости нет!</div>
			 </div>
			 <?php
		 }
		 else { ?>
		 	<a href="<?= HOST . "pages-index.php"?>" class="back">Back</a>				
			<div id="note">
				<h2 ><?= $page['name'] ?></h2>
				<p><?= $page['content'] ?></p>
				<p><br>Published by: <?= $page['published_date'] ?></p>
				</a>
			</div>
			<?php
		 }
	 } ?>
	</div>
</div>

<?php
	include "include/footer.php";
?>