<?	class Product_Images extends Entity
	{	
		public
			$fields  =
            [
               'product_id'	=> ['type' => 'int', 	 'ref' => 1, 'refTable' => 'products', 'refName' => 'id'],
               'image_name'	=> ['type' => 'varchar', 'ref' => 0],     
            ];

			function __construct ()
			{
				$this->tableName = ['product_images', 'Товары'];
				parent::__construct ();
			}
			
			function getImage ($id)
			{
				$result = $this->select (['product_id', 'image_name'], 'product_images.product_id='.$id, PDO::FETCH_ASSOC);	
				if (empty ($result[0])) return;	
				$offset = strpos ($result[0]['image_name'], '_');	
				$product_id = substr ($result[0]['image_name'], 0, $offset);	
				$image_name = substr ($result[0]['image_name'], $offset+1);					
				if ($product_id == $result[0]['product_id']) 
				{
					$data['image']['thumb'] = '/uploads/'.$product_id.'_thumb_'.$image_name;
					$data['image']['normal'] = '/uploads/'.$product_id.'_'.$image_name;
				}
				return $data;
			}
			
			function getImages ($ids = [])
			{
				global $db;
				if (empty ($ids))
					$result = $this->select (['product_id', 'image_name'], '', PDO::FETCH_ASSOC);
				else
					$result = $this->select (['product_id', 'image_name'], "product_id IN (".implode(' ,', $ids).")", PDO::FETCH_ASSOC);
				foreach ($result as $key => $items)
				{
					$offset = strpos ($items['image_name'], '_');
					$product_id = substr ($items['image_name'], 0, $offset);
					$image_name = substr ($items['image_name'], $offset+1);
					if ($product_id == $items['product_id']) 
					{
						$data['image'][$product_id]['thumb'] = '/uploads/'.$product_id.'_thumb_'.$image_name;
						$data['image'][$product_id]['normal'] = '/uploads/'.$product_id.'_'.$image_name;
					}
				}
				return $data;
			}
			
			function deleteImages ($ids)
			{
				$data = $this->getImages ($ids);
				foreach ($data['image'] as $product_id => $value)
				{
					unlink ($_SERVER['DOCUMENT_ROOT'].$value['thumb']);		//site_path
					unlink ($_SERVER['DOCUMENT_ROOT'].$value['normal']);
				}
			}
	}
?>