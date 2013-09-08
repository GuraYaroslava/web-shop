<?	function __autoload ($class_name) 
	{
        $filename = strtolower ($class_name).'.php';
        $file = site_path.'classes'.DIRSEP.$filename;
        if (file_exists ($file)) 
			require_once ($file);
		$file = site_path.'mvc/models'.DIRSEP.$filename;
        if (file_exists ($file)) 
			require_once ($file);
	}
	
	define ('DIRSEP', DIRECTORY_SEPARATOR);
	$site_path = dirname (dirname (__FILE__)).DIRSEP;	
	define ('site_path', $site_path);
?>