<?	class Controller_Enter
    {
		function faceControl ()
		{			
			global $template;
			if (isset ($_COOKIE['login']) && $_COOKIE['user_id'] && $this->check ())
			{  
				$template->set ('check', true);
			}
			else
			{
				$template->set ('check', false);
				if (!empty ($_POST['args'][0]))
				{
					switch ($_POST['args'][0])
					{
						case 'nepass':   
							$error = 'Пароли не совпадают.';
							break;
						case 'not_auth': 
							$error = 'Введённый вами login или пароль неверный.';
							break;
						case 'fields':   
							$error = 'Не заполнены все поля.';
							break;
						case 'exists':   
							$error = 'Пользователь с таким именем уже существует.';
							break;
						case 'imp':   
							$error = 'Только зарегистрированный пользователь может сделать заказ.';
							break;
					}
					$template->set ('error', $error);
				}				
			}
			$template->show ('enter');
		}
		
		function registration ()
		{
			$user = new Enter;
			$user->reg ();
			$user->auth ();
		}
		
		function authorization ()
		{
			$user = new Enter;
			$user->auth ();
		}
		
		function clearFace ()
		{	
			$user = new Users;
			$user_id = $_COOKIE['user_id'];
			$user->delete ([$user_id]);
			setcookie ('login', '', time()-900, '/');
			setcookie ('user_id', '', time()-900, '/');
			header ('Location: /enter/faceControl');
		}
		
		function out ()
		{
			$user = new Enter;
			$user->out ();
		}
		
		function check ()
		{
			$user = new Enter;
			return $user->check ();
		}
	}
?>