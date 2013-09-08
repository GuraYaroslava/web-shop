<?	class Entity
	{
		public
			$tableName = array (), 
			$fields = array (); 
		
		function __construct ()
		{	
			foreach ($this->fields as $key => $value) 
			{
				$refData = array ();
				if ($value['ref'] == 1) 
				{
					$model = new $value['refTable'] ();
					$data = $model->select (['id', $value['refName']], '', PDO::FETCH_ASSOC);
					foreach ($data as $row)
						$refData[$row['id']] = $row[$value['refName']];
					$this->fields[$key]['refData'] = $refData;
				}
			}
		}
		
		public function update ($columns, $values, $id)
		{
			global $db;
			$tableName = $this->tableName[0];
			$param = array_map (function ($a) {return "$a=:$a";}, $columns);
			$query = "UPDATE $tableName SET ".implode (', ', $param)." WHERE id=:id";
			$result = $db->prepare ($query);
			if (!$result) return false;
			$parameters = array_combine (array_map (function ($a) {return ":$a";}, $columns), $values);
			$parameters[':id'] = $id;	
			return $result->execute ($parameters);
		}
		
		public function add ($columns, $values)
		{
			global $db;
			$tableName = $this->tableName[0];
			$query = "INSERT INTO $tableName (".implode (', ', $columns).") VALUES(:".implode (', :', $columns).")";
			$result = $db->prepare ($query);
			if (!$result) return false;   
			$parameters = array_combine (array_map (function ($a) {return ":$a";}, $columns), $values);	
			return $result->execute ($parameters);
		}
		
		public function delete ($values)	
		{
			global $db;
			$tableName = $this->tableName[0];
			if (!isset ($values)) return false;   
			$count = count ($values);
			for ($i = 0; $i < $count ; $i++) $ids[$i] = ':'.$i;		
			$result = $db->prepare ("DELETE FROM $tableName WHERE id IN (".implode (', ', $ids).")");
			if (!$result) return false;
			$parameters = array_combine ($ids, $values);
			return $result->execute ($parameters);
		}
			
		public function select ($selectArgs, $condition, $selectType = PDO::FETCH_NUM)
		{
			global $db;
			$curTable = $this->tableName[0];
			$query = "SELECT ";
			$fields = array_map (function ($a) {$curTable = $this->tableName[0]; return "$curTable.$a";}, $selectArgs);
			$query .= implode (', ', $fields)." FROM $curTable ";
			if ($condition != '') $query .= " WHERE ".$condition;
			$query .= " ORDER BY ".$fields[0];
			//print($query);
			$result = $db->query ($query);
			return $result->fetchAll ($selectType);
		}
			
		public function colModel ()
		{	
			$fields = $this->fields;
			$id = array_shift ($fields);
			$response = array ();
			$i = 0;
			foreach ($fields as $key => $field)
			{
				$response[$i]['name'] = $key;
				$response[$i]['index'] = $key;
				$response[$i]['editable'] = true;
				if ($this->fields[$key]['ref'] == 1)
				{
					$response[$i]['formatter'] = 'select';
					$response[$i]['edittype'] = 'select';
					$response[$i]['stype'] = 'select'; 
					$response[$i]['search'] = true;
					$str = '';						
					foreach ($this->fields[$key]['refData'] as $id => $value)
						$str .= $id.':'.$value.';';
					$response[$i]['editoptions']['value'] = substr ($str, 0, strlen ($str) - 1);
					$response[$i]['searchoptions']['value'] = ':All;'.substr ($str, 0, strlen ($str) - 1);
				}	
				$i++;
			}
			if ($this->tableName[0] == 'products')
			{
				$response[$i]['name'] = 'image';
				$response[$i]['index'] = 'image';
				$response[$i]['manual'] = true;	//???
				$response[$i]['sortable'] = false;
				$response[$i]['search'] = false;
				$response[$i]['edittype'] = 'image';
			}
			return json_encode ($response);	
		}
			
		public function colNames ()
		{	
			$selectArgs = $this->fields;
			$id = array_shift ($selectArgs);
			$response = array ();
			foreach ($selectArgs as $key => $column)
				$response[] = $column['caption'];
			if ($this->tableName[0] == 'products')
				$response[] = 'Изображение';
			return json_encode ($response);	
		}
			
		public function getTable ()
		{
			$columns = array_keys ($this->fields);
			$data = $this->select ($columns, '', PDO::FETCH_ASSOC);
			if ($this->tableName[0] != 'products')
				$response = $data;
			else
			{
				$prod_img = new Product_Images;
				$images = $prod_img->getImages ();
				foreach ($data as $key => $items)
					$response[] = array_merge ($items, ['image' => '<a href="/admin/editImage/'.$items['id'].'">image<img src="'.$images['image'][$items['id']]['thumb'].'" /></a>']);
			}
			return $response;					
		}
	}
?>