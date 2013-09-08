<?	class Uploader 
	{
		public	$validExtensions = ['jpg', 'jpeg', 'png', 'gif'],
				$sizeLimit = null,
				$uploadDirectory = '';
		
		public function upload ($id)
		{
			$size = $_FILES['userfile']['size'];
			$name = $_FILES['userfile']['name'];
			$type = strtolower (pathinfo ($name, PATHINFO_EXTENSION)); 
			$this->sizeLimit = min ($this->letToNum (ini_get('post_max_size')), $this->letToNum (ini_get ('upload_max_filesize')));
			$uploadDir = $this->uploadDirectory;			
			$result = array (); 			
			if ($_FILES['userfile']['error'] !== UPLOAD_ERR_OK) 
			{ 
				$error_values = 
				[ 
					UPLOAD_ERR_FORM_SIZE  => 'Размер файла превышает указанное значение в MAX_FILE_SIZE.',
					UPLOAD_ERR_PARTIAL    => 'Файл был загружен только частично.', 
					UPLOAD_ERR_NO_FILE    => 'Не был выбран файл для загрузки.', 
					UPLOAD_ERR_NO_TMP_DIR => 'Не найдена папка для временных файлов.', 
					UPLOAD_ERR_CANT_WRITE => 'Ошибка записи файла на диск.'
				];						
				if (!empty ($error_values[$_FILES['userfile']['error']])) 
					$result['errors'][] = $error_values[$_FILES['userfile']['error']]; 
			}				
			if ($size > $this->sizeLimit)
				$result['errors'][] = 'Размер файла превышает '.($this->sizeLimit/1024/1024).'M';			
			if (!in_array ($type, $this->validExtensions))
			{
				$these = implode (', ', $this->validExtensions);
				$result['errors'][] = 'Расширениями файла могут быть: '.$these.'.';
			}
			if (empty ($result['errors']))
			{
				$imageName = basename ($name); //name = $_FILES['userfile']['name']
				$this->moveIntoDB ($id, $id.'_'.$imageName);
				move_uploaded_file ($_FILES['userfile']['tmp_name'], $uploadDir.$id.'_'.$imageName);
				copy ($uploadDir.$id.'_'.basename ($name), $uploadDir.$id.'_thumb_'.$imageName);
				$result['success'] = true;
			}
			else $result['success'] = false;
			return $result;
		}	
		
		function makeThumb ($type, $src, $dest, $desired_width) 
		{
			switch ($type) 
			{
				case 'jpeg':
					$source_image = @imagecreatefromjpeg ($src);
					break;
				case 'jpg':
					$source_image = @imagecreatefromjpeg ($src);
					break;
				case 'gif':
					$source_image = @imagecreatefromgif ($src);
					break;
				case 'png':
					$source_image = @imagecreatefrompng ($src);
					break;
			}
			
			$width = imagesx ($source_image);	
			$height = imagesy ($source_image);	
			$desired_height = $desired_width;
			if ($width > $height) 
				$desired_height = floor ($height * ($desired_width / $width));	
			else 
				$desired_width = floor ($width * ($desired_height / $height));	
			$virtual_image = imagecreatetruecolor ($desired_width, $desired_height);
			imagecopyresampled ($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
			switch ($type) 
			{
				case 'jpeg':
					imagejpeg ($virtual_image, $dest);
					break;
				case 'jpg':
					imagejpeg ($virtual_image, $dest);
					break;
				case 'gif':
					imagejpeg ($virtual_image, $dest);
					break;
				case 'png':
					imagepng ($virtual_image, $dest);
					break;
			}
	   }
		
		function moveIntoDB ($product_id, $image_name)
		{
			global $db;
			$model = new Product_Images;
			$result = $model->select(['id'], 'product_images.product_id='.$product_id, PDO::FETCH_ASSOC);
			if (empty ($result)) 
				$model->add (['product_id', 'image_name'], [$product_id, $image_name]);	
			else 
			{
				$model->deleteImages ([$product_id]);
				$model->update (['product_id', 'image_name'], [$product_id, $image_name], $result[0]['id']);
			}
		}
		
		public function letToNum ($v) 	
		{ 									
			$l = substr ($v, -1);
			$ret = substr ($v, 0, -1);
			switch (strtoupper ($l))
			{
				case 'G':
					$ret *= 1024;
				case 'M':
					$ret *= 1024;
				case 'K':
					$ret *= 1024;
					break;
			}
			return $ret;
		}
	}
?>