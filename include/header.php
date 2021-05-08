<!DOCTYPE html>
<html lang="ru-RU">
	<head>
		<meta charset="utf-8">
		<title><?=(isset($PAGE_TITLE) && ($PAGE_TITLE != "") ? $PAGE_TITLE : "Больница №10");?></title>
		<link rel="stylesheet" type="text/css" href="assets/css/style.css">	
		<link rel="stylesheet" type="text/css" href="assets/css/shop-style.css">
		<link rel="stylesheet" type="text/css" href="assets/css/news-style.css">
		<link rel="stylesheet" type="text/css" href="assets/css/pages-style.css">	
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>		
		<link rel="stylesheet" href="assets/css/jquery.fancybox.min.css" />
	</head>
	<body onload="loadLogo()">
		<div class="window">	
			<header>
				<div class="logo">
					<a href="index.php"><img id="anim" src="assets/images/logo.png"></a>    
				</div> 		 				
				<div class="menu_item">
					<ul>
						<li class="item follow">
							<a href="#" class="menu_link"><span class="menu_item_text">подписка</span></a>
						</li>
						<li class="item price">
							<a href="#" class="menu_link"><span class="menu_item_text">прайс</span></a>
						</li>		
						<li class="item order">
							<a href="#" class="menu_link"><span class="menu_item_text">заказы</span></a>
						</li>
					</ul>
					<ul>
						<li class="itemt shop">
							<a href="#" class="menu_link"><span class="menu_item_text">интернет-магазин</span></a>
						</li>
						<li class="itemt report">
							<a href="#" class="menu_link"><span class="menu_item_text">отчеты</span></a>
						</li>
					</ul>
				</div>
				<div class="middle_div">
					<form class="forma" action="#">
						<p>
							<span class="login_text">ЛОГИН</span>
							<input type="text" name="login" class="login_field">
						</p>
						<p>
							<span>ПАРОЛЬ</span>
							<input type="password" name="password" class="pass_field">
						</p>
						<input type="submit" name="go" class="access_btn" value="ВОЙТИ">
					</form>
					<div class="linqs">
						<p class="newspaper_linq"><a href="#">ГАЗЕТА ></a></p>
						<p class="product_linq"><a href="#">ТОВАРЫ ></a></p>
						<p class="partner_linq"><a href="#">ПАРТНЕРЫ ></a></p>
						<p class="follow_linq"><a href="#">ПОДПИСКА ></a></p>
						<p class="reg_linq"><a href="reg-index.php">РЕГИСТРАЦИЯ ></a></p>
					</div>
				</div>
				<div class="page_header">
					<img src="assets/images/left_figure.png" class="left_figure">
					<div <?=$PAGE_CSS;?>>
						<p class="page_name"><?=$PAGE_H1;?></p>
						<img src="assets/images/right_figure.png" class="right_figure">
					</div>
				</div>			
			</header>
			<main>