<?	class Controller_Cart
	{	
		function add ()
		{
			$cart = new Cart;
			$user_id = $_COOKIE['user_id'];
			$product_id = $_POST['args'][0];
			if (isset ($_COOKIE['login']) && isset ($_COOKIE['user_id'])) 
				$cart->addIntoDB ($user_id, $product_id);
			else
				$cart->addIntoSession ($product_id);	
			header ('Location: '.$_SERVER['HTTP_REFERER']);
		}
		
		function get ()
		{
			$cart = new Cart;
			$user_id = $_COOKIE['user_id'];
			if (isset ($_COOKIE['login']) && isset ($_COOKIE['user_id'])) 
				return $cart->getDataFromDB ($user_id);
			else
				return $cart->getDataFromSession ();
		}
		
		function edit ()
		{
			global $template;
			$template->show ('cart');
		}
		
		function refresh ()
		{
			$cart = new Cart;
			$user_id = $_COOKIE['user_id'];
			if (isset ($_COOKIE['login']) && isset ($_COOKIE['user_id'])) 
				$cart->refreshTableData ($user_id);
			else
				$cart->refreshSessionData ();	
			header ('Location: /cart/edit');
		}
		
		function clear ()
		{
			$cart = new Cart;
			$user_id = $_COOKIE['user_id'];
			if (isset ($_COOKIE['login']) && isset ($_COOKIE['user_id'])) 
				return $cart->clearCartFromDB ($user_id);
			else
				return $cart->clearCartFromSession ();			
		}
	}
?>