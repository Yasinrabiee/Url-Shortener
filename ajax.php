<?php
	require_once './main.php';
	require_once './middlewares/auth.php';
	$middleware = new Auth();
	$middleware->handle();

	$op = ACC::post('op') ?? '';
	
	if ($op == 'list-of-links')
	{
		header('Content-Type: application/json');
		$where = $_POST['where'];
		$sortField = ACC::post('sortField');
		$orderBy = ACC::post('orderBy');

		$whereArray = ['uid' => $userInfo[0]['id']];
		$whereQ = 'uid = :uid AND ';

		foreach ($where as $searchOp => $value)
		{
			if (!empty($value))
			{
				$whereQ .= "$searchOp LIKE :$searchOp AND ";
				$whereArray[$searchOp] = '%'.$value.'%';
			}
		}

		$params =
		[
			'table' => 'link',
			'columns' => '*',
			'where' => trim(ACC::str_replace_last('AND', '', $whereQ)),
			'whereArray' => $whereArray,
			'order' => "order by $sortField $orderBy"
		];
		
		echo json_encode(DB::select($params));
	}
?>