<?	session_start ();
	error_reporting (E_ALL);
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/startup.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/connect.php';
	$template = new Template ();
	$router = new Router ();
	$router->setPath (site_path.'mvc\controllers'); 
	$router->delegate ();
?>