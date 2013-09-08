<?	class Products extends Entity
	{	
		public
			$fields  =
            [
               'id'     => ['name' => 'id',     'caption' => '№', 		 'type' => 'int', 	'ref' => 0],
               'label'  => ['name' => 'label',  'caption' => 'Артикул',  'type' => 'text', 	'ref' => 0],
               'name'   => ['name' => 'name',   'caption' => 'Название', 'type' => 'text', 	'ref' => 0],
               'price'  => ['name' => 'price',  'caption' => 'Цена', 	 'type' => 'int', 	'ref' => 0],
               'amount' => ['name' => 'amount', 'caption' => 'Кол-во', 	 'type' => 'text', 	'ref' => 0],
            ];

			function __construct ()
			{
				$this->tableName = 'products';
				$this->caption = 'Товары';
				parent::__construct ();
			}
			
			function getCatalog ($category_id)
			{
				global $db;
				$result = $db->prepare ("SELECT products.id, products.label, products.name, products.price, products.amount
										FROM product_category 
										INNER JOIN products ON product_category.product_id = products.id
										INNER JOIN categories ON product_category.category_id = categories.id
										WHERE product_category.category_id = " . $category_id);	//param!!!
				$result->execute ();
				if (!$result) return 0;
				foreach ($this->fields as $key => $column)
					$titlesArr[] = $column['caption'];
				array_shift ($titlesArr);	//№
				$prod_img = new Product_Images;	
				$varArr = ['tableRows'   => $result->fetchAll (PDO::FETCH_ASSOC),
						   'tableTitles' => $titlesArr,
						   'columns' => array_keys ($this->fields)];
				return array_merge ($varArr, $prod_img->getImages ());
			}
	}
?>