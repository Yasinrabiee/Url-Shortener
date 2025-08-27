<?php 

	class Auth
	{

		public function handle()
		{
			$cookie = isset($_SESSION[_AUTH_NAME]) ? 0 : 1;
			$userpass = isset($_SESSION[_AUTH_NAME]) ? $_SESSION[_AUTH_NAME] :
			(isset($_COOKIE[_AUTH_NAME]) ? $_COOKIE[_AUTH_NAME] : '');
			
			if (!empty($userpass))
			{
				$userpass = explode(':', $userpass);
				$params =
				[
			    'table' => 'user',
			    'columns' => '*',
			    'where' => 'username = :username AND password = :password',
			    'whereArray' => ['username' => $userpass[0], 'password' => $userpass[1]],
				];
				$GLOBALS['userInfo'] = DB::select($params);
				
				if (count($GLOBALS['userInfo']) > 0)
				{
					$isLoggedIn = true;
				}
				else
				{
					$isLoggedIn = false;
					
					header('location: ' . ACC::asset('/logout'));
				}
			}
			else
			{
				if (strpos($_SERVER['REQUEST_URI'], 'login') == 0)
				{
					header('location: ' . ACC::asset('/login'));
				}
			}
		}
	}

?>