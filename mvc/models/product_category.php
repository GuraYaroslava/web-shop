<?	class Product_Category extends Entity
	{	
		public
			$fields  =
            [
				'id' => ['name' => 'id', 'caption' => '№', 'type' => 'int', 'ref' => 0],
			   
				'product_id' => ['name' => 'product_id', 'caption' => 'Название', 'type' => 'int', 
				'ref' => 1, 'refTable' => 'products', 'refName'  => 'name'],
				
				'category_id' => ['name' => 'category_id', 'caption' => 'Категория', 'type' => 'int', 
				'ref' => 1, 'refTable' => 'categories', 'refName'  => 'name']
            ];

		function __construct ()
		{
			$this->tableName = 'product_category';
			$this->caption = 'Товар - Категория';
			parent::__construct ();
		}
	}
?>