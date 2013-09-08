<?	class Enter
	{	
		function hash ($password, $user_agent, $user_time) 	
		{  
			return substr (md5 ($password).md5 ($user_agent).md5 ($user_time), 0, 22);  
		}
		
		function reg ()
		{
			if (empty ($_POST['login']) || empty ($_POST['pass1']) || empty ($_POST['pass2']))
				$this->redirect ('fields');  
			if (md5 ($_POST['pass1']) != md5 ($_POST['pass2']))
				$this->redirect ('nepass'); 
			$users = new Users;
			$result = $users->select (['login'], 'login="'.$_POST['login'].'"', PDO::FETCH_ASSOC);
			if (count ($result) > 0)
				$this->redirect ('exists');
			$users->add (['login', 'time', 'hash'], [$_POST['login'], time(), $this->hash ($_POST['pass1'], $_SERVER['HTTP_USER_AGENT'], time())]);
			$_POST['pass'] = $_POST['pass1'];
			$this->auth ();
		}
		
		function auth ()
		{
			if (empty ($_POST['login']) || empty ($_POST['pass']))
				$this->redirect ('fields'); 		
			$users = new Users;
			$result = $users->select (['id', 'login', 'time', 'hash'], 'login="'.$_POST['login'].'"', PDO::FETCH_ASSOC);			
			if (empty ($result))
					$this->redirect ('not_auth');
			if ($this->hash ($_POST['pass'], $_SERVER['HTTP_USER_AGENT'], $result[0]['time']) == $result[0]['hash'])
			{
				setcookie ('login', $result[0]['login'], time()+900, '/');
				setcookie ('user_id', $result[0]['id'], time()+900, '/');
				$users->update (['time'], [time ()], $result[0]['id']);
				unset ($_SESSION['cart']);
				$this->redirect ('');
			}
			else 
				$this->redirect ('not_auth');
		}
		
		function redirect ($msg)
		{
			header ('Location: /enter/faceControl/'.$msg);
			exit;
		}
		
		function check ()
		{
			$users = new Users;
			$user = $users->select (['id', 'login', 'time', 'hash'], 'login="'.$_COOKIE['login'].'"', PDO::FETCH_ASSOC);
			if (empty ($user))
			{
				return false;
				$this->redirect ('not_auth');			
			}
			if ($user[0]['time'] < (time()-900)) 
				return false;
			$users->update (['time'], [time()], $user[0]['id']);
			setcookie ('login', $_COOKIE['login'], time()+900, '/');
			setcookie ('user_id', $_COOKIE['user_id'], time()+900, '/');
			return true;
		}
		
		function out ()
		{
			$users = new Users;
			$user = $users->select (['id', 'login','time', 'hash'], 'login="'.$_COOKIE['login'].'"', PDO::FETCH_ASSOC);
			if (empty ($user))
				$this->redirect ('not_auth');
			$users->update (['time'], [time()-900], $user[0]['id']);
			setcookie ('login', '', time()-900, '/');
			setcookie ('user_id', '', time()-900, '/');
			$this->redirect ('');
			return true;
		}
	} 
?>  