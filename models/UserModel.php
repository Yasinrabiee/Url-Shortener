<?php
	class User
	{
		public static function insert($params)
		{
			$dbParams = [];
			$dbParams['table'] = 'user';
			$dbParams['fields'] = 
	    [
	      'username' => $params['username'],
	      'password' => md5($params['password']),
	      'fname' => $params['fname'],
	      'lname' => $params['lname'],
	      'email' => $params['email']
	    ];
			
			if (DB::insert($dbParams) > 0)
			{
				return true;
			}

			return false;
		}

		public static function auth($username, $password)
		{
			$params =
			[
		    'table' => 'user',
		    'columns' => '*',
		    'where' => 'username = :username AND password = :password',
		    'whereArray' => ['username' => $username, 'password' => $password],
		    'count' => true
			];

			return DB::select($params);
		}
	}
?>