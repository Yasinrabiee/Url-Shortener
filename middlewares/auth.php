<?php 

	class Auth
	{
		public function handle()
		{
			$userpass = $_COOKIE[_AUTH_NAME] ?? '';
			
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
