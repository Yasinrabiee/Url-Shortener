<?php
	use Bramus\Router\Router;

	require_once 'vendor/autoload.php';
	require_once 'controllers/controller.php';
	require_once 'main.php';

	# Create instance of the RouterClass
	$router = new Router();

	# Define routes
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

	# Custom 404 handling
	$router->set404(function()
	{
  	header('HTTP/1.1 404 Not Found');
		echo "Not Found!";  
	});

	# Run routes
	$router->run();
?>