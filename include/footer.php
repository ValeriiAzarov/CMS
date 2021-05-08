				<div class="menu_bar">
					<img src="assets/images/site-menu.png">
					<a href="#"><p class="main_page">> ГЛАВНАЯ СТРАНИЦА</p></a>
					<a href="#"><p class="news_page">> НОВОСТИ</p></a>
					<a href="#"><p class="company_page">> О ФИРМЕ</p></a>
					<a href="#"><p class="price_page">> ПРАЙС-ЛИСТ</p></a>
					<a href="#"><p class="map_page">> КАРТА САЙТА</p></a>
					<a href="#"><p class="job_page">> НОВЫЕ ВАКАНСИИ</p></a>
					<a href="#"><p class="follow_page">> ПОДПИСКА</p></a>
					<a href="#"><p class="shop_page">> ИНТЕРНЕТ МАГАЗИН</p></a>
					<a href="#"><p class="navigator_page">> ФАРМ-НАВИГАТОР</p></a>
					<a href="#"><p class="about_page">> КАК К НАМ ПРОЕХАТЬ</p></a>
					<a href="reg-index.php"><p class="reg_page">> REGISTRATION</p></a>
					<a href="server-index.php"><p class="server_page">> SERVER</p></a>
					<a href="http://k503labs.ukrdomen.com/labs/535a/v.azarov/lab12/cms/"><p class="server_page">> CMS</p></a>
					<a href="shop-index.php"><p class="file_manager_page">> SHOP</p></a>
				</div>
			</div>
		</main>
	</body>
	<?php
	if ( isset($PAGE_JS) && (count($PAGE_JS)>0) )
	{
		for($i=0;$i<count($PAGE_JS);$i++)
		{
			echo '<script src="'.$PAGE_JS[$i].'"></script>';
		}
	}
?>
</html>