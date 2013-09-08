<?	require_once $_SERVER['DOCUMENT_ROOT'].'/mvc/controllers/cart.php'; // Что значит include once
	function  getMenu ()
	{	
		$print = '<ul>';	
		$MenuItems = array ('Главная' => '/');
		foreach ($MenuItems as $name => $item)
			$print .= '<li class="border"><a href="'.$item.'">'.$name.'</a></li>';				
		$enter = new Enter;		
		if (isset ($_COOKIE['login']) && isset ($_COOKIE['user_id']) && $enter->check ())
			$print .= '<li class="border"><a href="/enter/faceControl">'.$_COOKIE['login'].'</a> [ <a href="/enter/out">выйти</a> ]</li>';		
		else $print .= '<li class="border"><a href="/enter/faceControl">Вход</a></li>';				
	
		$print .= '</ul>';
		return  $print;	
	}
	$cart = new Controller_Cart;
	$smal_cart = $cart->get ();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title>JEWELERY</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="shortcut icon"   type="text/css" type="image/x-icon" href="/images/site.png" />
		<link rel="stylesheet" type="text/css" media="screen" href="/css/jquery.treeview.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="/css/style.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="/css/smoothness/jquery-ui-1.10.3.custom.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="/css/smoothness/jquery-ui-1.10.3.custom.min.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="/css/ui.jqgrid.css" /> 
		
		<script type="text/javascript" src="/js/jquery-1.10.2.js"></script>
		<script type="text/javascript" src="/js/jquery.cookie.js"></script>
		<script type="text/javascript" src="/js/jquery.treeview.js"></script>
		<script type="text/javascript" src="/js/jquery-1.9.0.min.js"></script>
		<script type="text/javascript" src="/js/i18n/grid.locale-ru.js"></script>
		<script type="text/javascript" src="/js/jquery.jqGrid.min.js"></script>
		<script type="text/javascript" src="/js/jquery-ui-1.10.3.custom.js"></script>		<!-- -->
		<script type="text/javascript" src="/js/jquery-ui-1.10.3.custom.min.js"></script> 	<!-- -->
	</head>
	<body>
		<div id="wrapper">
			<div id="header">
				<div class="logo"><a href="/"><h2><i>JEWELERY</i></h2></a></div>
				<div class="smalcart">
					<strong>Товаров в корзине:</strong>  <?=$smal_cart['cart_count']?> шт.<br/>
					<strong>На сумму:</strong>  <?=$smal_cart['cart_price']?> $<br/>
					<p>
						<a href='/cart/edit'><strong><i>Корзина</i></strong></a>
					</p>
				</div><?//print_r($_COOKIE)
				//print(date('y.m.d'));?>
				<?global $template;
					$data = json_encode ($template->get ('answer'));
					//print_r($data);
					//print_r($_SESSION['data']);
					//print(time());
					//print_r(date('d-m-Y', time()));?>
				<div class="menu"><?=getMenu ();?></div>	
			</div>