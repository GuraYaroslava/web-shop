<?	class Controller_Admin  
	{		
		function editTable ()
		{
			global $template;			
			$objName = $_POST['args'][0];	
			$obj = new $objName;
			$template->set ('data', json_encode ($obj->getTable ()));
			$template->set ('colModel', $obj->colModel ());
			$template->set ('colNames', $obj->colNames ());
			$template->show ('edit');
			return true;
		}
		
		function editImage ()
		{
			global $template; 	
			$id = $_POST['args'][0];	
			$prod_img = new Product_Images;
			$data = $prod_img->getImage ($id);
			$data['id'] = $id;
			$template->set ('image', $data);
			$template->show ('image_card');
			return true;
		}
		
		function loadImage () 
		{
			global $template;
			$id = $_POST['args'][0];
			$uploader = new Uploader;
			$uploader->uploadDirectory = $_SERVER['DOCUMENT_ROOT'].'/uploads/';
			$result = $uploader->upload ($id);
			if (!$result['success'])
			{
				$template->set ('errors', $result['errors']);
				$template->show ('error');
				return false;
			}
			$name = $_FILES['userfile']['name'];
			$fname = $_SERVER['DOCUMENT_ROOT'].'/uploads/'.$id.'_'.$name;
			$fname_thumb = $_SERVER['DOCUMENT_ROOT'].'/uploads/'.$id.'_thumb_'.$name;				
			$type = pathinfo ($name, PATHINFO_EXTENSION);								
			$uploader->makeThumb ($type, $fname, $fname_thumb, 100); 					
			header ('Location: '.$_SERVER['HTTP_REFERER']);
			return true;
		}

		function edit ()
		{
			if (in_array ('', $_POST)) 
				die ('What have you dane?!');
			$tableName = $_POST['args'][0];
			$obj = new $tableName ();
			if ($_POST['args'][1] == 'changeRoot')
			{
				$result = $obj->update (['parent_id'], [0], $_POST['Root']);
			}
			else
			{
				$columns = array_keys ($obj->fields);
				array_shift ($columns);		//id
				foreach ($columns as $key => $value)
					$values[] = $_POST[$value];
				$id = $_POST['id'];			
				switch ($_POST['oper']) 
				{
					case 'add':
						$result = $obj->add ($columns, $values);															
						break;
					case 'edit':
						$result = $obj->update ($columns, $values, $id);	
						break;
					case 'del':
						if ($tableName == 'products')
						{
							$prod_img = new Product_Images;
							$prod_img->deleteImages (explode (',', $_POST['id']));
						}
						$result = $obj->delete (explode (',', $_POST['id']));
						break;
				}
			}
			if (!$result) 
				die ('What have you done?!');	
		}
		
		function report ()
		{
			global $template;
			$template->show ('report');
		}
		
		function seach ()
		{
			global $db/*, $template*/;
			$date = explode ('.', $_POST['before']);
			$start = mktime (0, 0, 0, $date[1], $date[0], $date[2]);
			$date = explode ('.', $_POST['after']);
			$finish = mktime (0, 0, 0, $date[1], $date[0], $date[2]);
			$query = 'SELECT date, name, email, phone, adres FROM orders WHERE date > '.$start.' AND date < '.$finish;
			if (($_POST['field'] != '0') && ($_POST['condition'] != '0') && ($_POST['value'] != ''))
			{
				//$fields = [];как сделать like?
				$obj = new Products ();
				$obj->update (['name'], [' AND '.$_POST['field'].'='.$_POST['value']], '61');
				$query .= ' AND '.$_POST['field'].'="'.$_POST['value'].'"';
			}
			$result = $db->query ($query);
			$data = $result->fetchAll (PDO::FETCH_ASSOC);
			foreach ($data as $key => &$items)
			{
				$time = $items['date'];
				$items['date'] = date ('Y-m-d', $time);
			} 
			//$template->set ('answer', $data);
			$_SESSION['data'] = $data;
		}
	}
?>