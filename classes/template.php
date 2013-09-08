<?	Class Template
	{
		private $vars = array();
		
		function set ($varname, $value) 
		{
			$this->vars[$varname] = $value;
		}
		
		function get ($key) 
		{
			return $this->vars[$key];
		}
		
		function show ($name) 
		{
			$path = site_path . 'mvc/views'.DIRSEP.$name.'.php';
			require_once ($path);  
		}
	}
?>
