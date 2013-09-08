<?	Class Router
	{
		private $path;
		
		function setPath ($path)
		{
			$path .= DIRSEP; 
			if (!is_dir ($path)) 
				throw new Exception ('Invalid controller path: `'.$path.'`');
			$this->path = $path;
		}
		
		private function getController (&$file, &$controller, &$action) 
		{
			$route = (empty ($_GET['route'])) ? '' : $_GET['route'];
			if (empty ($route))  $route = 'index'; 
			$parts = explode ('/', $route);
			$cmd_path = $this->path;
			foreach ($parts as $part) 
			{
				$fullpath = $cmd_path.$part;				
				if (is_dir ($fullpath)) 
				{
					$cmd_path .= $part.DIRSEP;
					array_shift ($parts); 
					continue;
				}
				if (is_file ($fullpath.'.php')) 
				{
					$controller = $part;
					array_shift ($parts);
					break;
				}
			}			
			if (empty ($controller)) 
				$controller = 'index';				
			$action = array_shift ($parts);
			if (empty ($action)) 
				$action = 'index'; 
			$file = $cmd_path.$controller.'.php';			
			$_POST['args'] = $parts;
		}
		
		function delegate () 
		{
			$this->getController ($file, $controller, $action);
			if (is_readable ($file) == false) 
				die ('404 Not Found file');	 
			require_once ($file);				
			$class = 'Controller_'.$controller;
			$controller = new $class ();			
			if (!is_callable (array ($controller, $action))) 
				die ('404 Not Found action');	
			$controller->$action ();
		}
	}
?>
