<?	class Cart extends Entity
	{			
		public
			$fields  =
            [
				'id' 		 => ['name' => 'user_id', 	'type' => 'int', 'ref' => 1, 'refTable' => 'users',    'refName' => 'id'], 
				'product_id' => ['name' => 'product_id', 'type' => 'int', 'ref' => 1, 'refTable' => 'products','refName' => 'id'],
				'amount'  	 => ['name' => 'amount',  	'type' => 'int', 'ref' => 0],
            ];
			
		function __construct ()
		{
			$this->tableName = 'cart'; 
			$this->caption = 'Корзина';
			parent::__construct ();
		}
		
		function addIntoSession ($product_id, $count = 1)
		{
			$_SESSION['cart'][$product_id] = $_SESSION['cart'][$product_id]+$count;		
			return true;
		}

		function addIntoDB ($user_id, $product_id, $count = 1)
		{
			$data = $this->select (['id', 'product_id', 'amount'], 'id="'.$user_id.'" AND product_id="'.$product_id.'"', PDO::FETCH_ASSOC);
			if (empty ($data))
				$this->add (['id', 'product_id', 'amount'], [$user_id, $product_id, $count]);
			else 
			{
				$query = 'UPDATE cart SET amount="'.$data[0]['amount']+$count.'" WHERE id="'.$user_id.'" AND product_id="'.$product_id.'"';
				$result = $db->prepare ($query);
				if (!$result) return false;
				$result->execute ();
			}
		}
		
		function getDataFromSession ()
		{
			$total_price = 0; 
			$total_count = 0;	
			if (isset ($_SESSION['cart']))
			{
				$result['empty'] = 0;
				$obj = new Products;
				foreach ($_SESSION['cart'] as $product_id => $amount)
				{ 
					$data = $obj->select (['label', 'name', 'price'], 'id="'.$product_id.'"', PDO::FETCH_ASSOC);
					$cost = $data[0]['price']*$amount;
					$total_price += $cost;
					$total_count += $amount;
					$result['goods'][$product_id] = array_merge ($data[0], ['amount' => $amount, 'cost' => $cost]);
				}			
			}
			else 
				$result['empty'] = 1;
			$result['cart_price'] = $total_price;
			$result['cart_count'] = $total_count;			
			return  $result;
		}
		
		function getDataFromDB ($user_id)
		{
			$user = $this->select (['product_id, amount'], 'id="'.$user_id.'"', PDO::FETCH_ASSOC);
			if (empty ($user))
				$result['empty'] = 1;
			else 
				$result['empty'] = 0;
			$total_price = 0; 
			$total_count = 0;
			$products = new Products;
			foreach ($user as $kye => $product)
			{
				$data = $products->select (['label', 'name', 'price'], 'id="'.$product['product_id'].'"', PDO::FETCH_ASSOC);
				$cost = $data[0]['price']*$product['amount'];
				$total_price += $cost;
				$total_count += $product['amount'];
				$result['goods'][$product['product_id']] = array_merge ($data[0], ['amount' => $product['amount'], 'cost' => $cost]);
			}
			$result['cart_price'] = $total_price;
			$result['cart_count'] = $total_count;			
			return  $result;
		}
		
		function refreshTableData ($user_id)
		{	
			global $db;
			array_pop ($_POST);		//refresh
			array_pop ($_POST);		//args 
			$post = $_POST;
			foreach ($post as $key => $new_count)
			{
				$action = substr ($key, 0, 4);
				$product_id = substr ($key, 4);
				if ($action == 'edi_') 
				{
					$query = 'UPDATE cart SET amount="'.$new_count.'" WHERE id="'.$user_id.'" AND product_id="'.$product_id.'"';
					$result = $db->prepare ($query);
					if (!$result) return false;
					$result->execute ();
				}
				elseif ($action == 'del_')
				{
					$result = $db->prepare ('DELETE FROM cart WHERE id="'.$user_id.'" AND product_id="'.$product_id.'"');
					if (!$result) return false;
					$result->execute ($parameters);
				}	
			}
			
		}
		
		function refreshSessionData ()
		{
			array_pop ($_POST);		//refresh
			array_pop ($_POST);		//args 
			$post = $_POST;
			foreach ($post as $key => $new_count)
			{
				$action = substr ($key, 0, 4);
				$product_id = substr ($key, 4);
				if ($action == 'edi_') 
				{
					$_SESSION['cart'][$product_id] = $new_count;
				}
				elseif ($action == 'del_')
				{
					unset ($_SESSION['cart'][$product_id]);
				}	
			}
		}
		
		function clearCartFromDB ($user_id)
		{
			$this->delete ($user_id);
		}
		
		function clearCartFromSession ()
		{
			unset ($_SESSION['cart']);	
		}		
	}
?>