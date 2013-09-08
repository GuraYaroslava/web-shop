<?	error_reporting (E_ALL & ~E_NOTICE);
	require_once 'config.php';
	try 
	{
		$db = new PDO ('mysql:host='.$db_host.'; dbname='.$db_name, $db_user, $db_pass);
		$db->query ("SET NAMES 'cp1251'");
		$db->setAttribute (PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
	}	
	catch (PDOException $error)
	{	
		error_log ($error->getMessage ());
		die ($error);
	}
?>