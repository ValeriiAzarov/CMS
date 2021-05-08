<?php
	$PAGE_TITLE = "NEWS";
	$PAGE_JS = Array();
	$PAGE_JS[] = 'assets/js/anim.js';
	$PAGE_H1 = "NEWS";
	$PAGE_CSS = 'class="page_name_border_1"';

	include "init.php";
	include "cms/classes/NewsModel.class.php";

	$news_model = new NewsModel($mysqli);
    $news = $news_model->get_all_news();

	include "include/header.php";
?>    
<div class="page_info">
	<div id="topics">
		<div> <?php
		if (!empty($news)) {
        	foreach ($news as $one_news) { ?>
				<div class="post-item">
					<div class="post-item-wrap">
						<a href="<?= $one_news['url'] ?>" target="_blank" class="post-link">
						<h3 class="post-title"><?= $one_news['name'] ?></h3>
						<p class="post-content"><?= $one_news['content'] ?></p>
						<p class="post-published-date">Published by: <?= $one_news['published_date'] ?></p>
						</a>
					</div>
				</div>
			<?php
			}
		} ?>
		</div>
		
	</div>
</div>

<?php
	include "include/footer.php";
?>