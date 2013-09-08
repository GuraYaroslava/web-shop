<?	class Controller_Order
    {
		function index ()
		{	
			global $template;
			if (!empty ($_POST['args'][0]) && $_POST['args'][0] == 'thanks')
			{
				$message = '<p class="border_black">Ваша заявка принята.</p>';
				$order = new Order;
				$order_content = $order->get ($_COOKIE['user_id']);
				$template-> set ('message', $message);
				$template-> set ('order_content', $order_content);
			}
			$template->show ('order');
			return true;
		}	
		
		function buy ()
		{
			global $template;
			$order = new Order;
			$result = $order->isValidData ($_REQUEST);
			if ($result['success']== false)
			{
				$template->set ('errors', $result['errors']);
				$template->show ('error');
				return false;
			}
			else 
			{
				$order->addOrder ($_REQUEST);
				$cart = new Cart;
				$cart->clear ();
				return true;
			}
		}		
	}
?>