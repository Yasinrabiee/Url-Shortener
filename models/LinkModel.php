<?php
	class Link
	{
		public static function insert($params)
		{
			$dbParams = [];
			$dbParams['table'] = 'link';
			$dbParams['fields'] = 
	    [
        'uri' => $params['uri'],
        'uid' => $GLOBALS['userInfo'][0]['id'],
        'target' => $params['target'],
        'password' => (!empty($params['password']) ? md5($params['password']) : '')
	    ];
			
			if (DB::insert($dbParams) > 0)
			{
				return true;
			}

			return false;
		}	

		public static function selectOne($uri)
		{
			return ACC::select('link', 'uri', $uri);
		}

		public static function delete($id)
		{
			$params = [];
			$params['table'] = 'link';
			$params['column'] = 'id';
			$params['ids'] = [$id];
			
			if (DB::delete($params) > 0)
			{
				return true;
			}

			return false;
		}
	}
?>