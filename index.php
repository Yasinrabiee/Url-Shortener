<?php
	use Bramus\Router\Router;

	require_once 'vendor/autoload.php';
	require_once 'main.php';
	require_once 'middlewares/auth.php';
	require_once 'controllers/controller.php';

	$router = new Router();

	$exceptions =
	[
		'/login',
		'/([a-zA-Z0-9\-]+)',
		'/redirect'
	];

	# Auth middleware
	$router->before('GET|POST', '/(.*)', function($param)
	{
		
		
		$middleware = new Auth();
		$middleware->handle();
	});


	$router->get('/', function()
	{
    $controller = new controller();
    $controller->index();
	});
	$router->post('/', function()
	{
		$controller = new controller();
		$controller->createLink();
	});

	$router->get('/login', function()
	{
    $controller = new controller();
    $controller->loginIndex();
	});
	$router->post('/login', function()
	{
  	$controller = new controller();
  	$controller->loginHandle();
	});

	$router->get('/logout', function()
	{
    $controller = new controller();
    $controller->logout();
	});

	$router->get('/([a-zA-Z0-9\-]+)', function($uri)
	{
    $controller = new controller();
    $controller->redirect($uri);
	});
	$router->post('/([a-zA-Z0-9\-]+)', function($uri)
	{
    $controller = new controller();
    $controller->viewLink($uri);
	});

	$router->set404(function()
	{
  	header('HTTP/1.1 404 Not Found');
		echo "Not Found!";  
	});

	$router->run();
?>