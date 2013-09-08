<?	require_once site_path.'mvc/controllers'.DIRSEP.'cart.php';
	class Order extends Entity
	{	
		public
			$fields  =
            [
				'date' 		=> ['name' => 'date', 	'caption' => 'Дата', 			'type' => 'int',	 'ref' => 0], 
				'name'		=> ['name' => 'name',  	'caption' => 'Имя', 			'type' => 'varchar', 'ref' => 0],
				'email' 	=> ['name' => 'email', 	'caption' => 'E-mail', 			'type' => 'varchar', 'ref' => 0], 
				'phone'		=> ['name' => 'phone',  'caption' => 'Телефон', 		'type' => 'varchar', 'ref' => 0],
				'adres' 	=> ['name' => 'adres',  'caption' => 'Адрес', 			'type' => 'varchar', 'ref' => 0],
				'content' 	=> ['name' => 'content','caption' => 'Заказ', 			'type' => 'varchar', 'ref' => 0],
				'user_id' 	=> ['name' => 'user_id','caption' => 'Номер клиента', 	'type' => 'int', 	 'ref' => 1, 
								'refTable' => 'users', 'refName' => 'id'],
            ];
			
		function __construct ()
		{
			$this->tableName = 'orders'
			$this->caption = 'Заказы';
			parent::__construct ();
		}
		
		function isValidData ($data)
		{
			if (!preg_match ("/^[A-Za-z0-9._-]+@[A-Za-z0-9_-]+.([A-Za-z0-9_-][A-Za-z0-9_]+)$/", $data['email']))	//квантификаторы: '+' min один символ, '^' начало строки, '$' конец строки, '.' любой символ
				$result['errors'][] = 'E-mail не существует!';	
			if (empty ($data['adres']) || empty ($data['phone']) || empty ($data['name']))
				$result['errors'][] = 'Не все поля заполнены!';	
			if (!empty ($result['errors']))
				$result['success'] = false;
			else
				$result['success'] = true;
			return $result;			
		}
		
		function addOrder ($data)
		{
			$cart = new Controller_Cart ();
			$result = $cart->get ();
			if (empty ($_COOKIE['user_id']) && empty ($_COOKIE['login']))
			{
				header ('Location: /enter/faceControl/imp');
				return false;
			}
			else
			{
				$order_content = serialize ($result);
				$values = [
							'date'		=> time (), 	
							'name' 		=> $data['name'], 
							'email' 	=> $data['email'],
							'phone'		=> $data['phone'],
							'adres'		=> $data['adres'],				
							'content'	=> $order_content,
							'user_id'	=> $_COOKIE['user_id']
						  ];
				$this->add (['date', 'name', 'email', 'phone', 'adres', 'content', 'user_id'], $values);
				$cart->clear ();
				header ('Location: /order/index/thanks');
				return true;
			}
		}

		function get ($user_id)
		{
			$result = $this->select (['content'], 'user_id='.$user_id);
			return unserialize ($result[0][0]);
		}
	}
?>  