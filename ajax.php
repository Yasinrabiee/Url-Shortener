<?php
	require_once './main.php';
	require_once './middlewares/auth.php';
	$middleware = new Auth();
	$middleware->handle();

	$op = ACC::post('op') ?? '';

	if ($op == 'list-of-links')
	{
		header('Content-Type: application/json');

		$params =
		[
			'table' => 'link',
			'columns' => '*',
			'where' => 'uid = :id',
			'whereArray' => ['id' => $userInfo[0]['id']]
		];
		
		echo json_encode(DB::select($params));
	}
?>