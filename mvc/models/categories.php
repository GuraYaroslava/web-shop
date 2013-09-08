<? 	class Categories extends Entity
	{	
		public
			$fields  =
            [
				'id'  	 	=> ['name' => 'id',   		'caption' => '№', 		  				'type' => 'int', 	 'ref' => 0],
				
				'name' 		=> ['name' => 'name', 		'caption' => 'Категория', 				'type' => 'varchar', 'ref' => 0], 
				
				'parent_id' => ['name' => 'parent_id',  'caption' => 'Родительская Категория',  'type' => 'int',   	 'ref' => 1,
				'refTable' 	=> 'categories', 'refName' => 'name']
            ];

		function __construct ()
		{
			$this->tableName = ['categories', 'Категории'];
			$data = $this->select (['id', 'name'], '', PDO::FETCH_ASSOC);
			foreach ($data as $key => $items)
				$names[$items['id']] = $items['name'];	
			$this->fields['parent_id']['refData'] = $names;
		}
		
		function getTree ()
		{
			$data = $this->select (['id', 'name', 'parent_id'], '', PDO::FETCH_ASSOC);
			foreach ($data as $key => $items)
				$tree[$items['parent_id']][] = $items;
			return $tree;
		}
		
		function getRoot ()
		{
			$data = $this->select (['id', 'name'], 'parent_id="0"', PDO::FETCH_ASSOC);
			return $data[0]['id'];
		}
	} 
?>  
  