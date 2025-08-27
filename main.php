<?php
	session_start();
	$isLoggedIn = false;
	$success = '';
	$error = '';
	$userInfo = '';

	require_once __DIR__.'/config.php';
	require_once __DIR__.'/defines.php';
	require_once __DIR__.'/includes/acc.php';
	require_once __DIR__.'/includes/class.db.php';

	$link = DB::connect();
?>