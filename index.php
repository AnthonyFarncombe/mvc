<?php

session_start();

define('ABSPATH', dirname( __FILE__ ) . '/');
require ABSPATH . 'config.php';
require ABSPATH . 'data.php';

$db = new datacontext();

$authorized = isset($_SESSION['id']);

if (!$authorized) {
	foreach ($allow_unauthorized_pages as $page) {
		if (preg_match("/$page/", $_SERVER['REQUEST_URI'])) {
			$authorized = true;
			break;
		}
	}
}

if (!$authorized) {
	header('Location: ' . LOGIN . '?returnurl=' . urlencode($_SERVER['REQUEST_URI']));
	exit;
}

$url = explode('?', $_SERVER['REQUEST_URI']);
$path = trim($url[0], '/');
$not_found = true;

$routes = simplexml_load_file('routes.xml') or die('Error: cannot load routes table');

foreach ($routes->route as $route) {
	$regex = '/' . $route->url . '/';
	
	if (preg_match($regex, $path, $matches)) {
		
		$valid_verb = false;
		$num_verbs = $route->verbs->verb->count();
		foreach ($route->verbs->verb as $verb) {
			if (((string)$verb ) === $_SERVER['REQUEST_METHOD']) {
				$valid_verb = true;
				break;
			}
		}
		if (!$valid_verb) {
			continue;
		}
		
		$not_found = false;
		$num_parameters = $route->parameters->parameter->count();
		
		for ($i = 0; $i < $num_parameters; $i++) {
			if (count($matches) > $i + 1) {
				$_GET[(string)$route->parameters->parameter[$i]] = $matches[$i + 1];
			}
		}
		
		$controller_name = (string)$route->controller;
		$action_name = (string)$route->action;
		
		if ($controller_name === 'mvc:controller') {
			if (isset($_GET['mvc:controller'])) {
				$controller_name = $_GET['mvc:controller'];
				unset($_GET['mvc:controller']);
			} else {
				$not_found = true;
			}
		}
		
		if ($action_name === 'mvc:action') {
			if (isset($_GET['mvc:action'])) {
				$action_name = $_GET['mvc:action'];
				unset($_GET['mvc:action']);
			} else {
				$not_found = true;
			}
		}

		break;
	}
}

if ($not_found) {
	include PAGENOTFOUND;
	exit();
}

$controller_name .= '_controller';
$action_name .= 'Action';

$controller_path = ABSPATH . 'controllers/' . $controller_name . '.php';
if (!file_exists($controller_path)) {
	include PAGENOTFOUND;
	exit();
}

require ABSPATH . 'controllers/controller.php';
require $controller_path;
$controller = new $controller_name();

if (method_exists($controller, 'authorize')) {
	if (!$controller->authorize()) {
		include PAGENOTFOUND;
		exit();
	}
}

$action_name_method = $action_name . $_SERVER['REQUEST_METHOD'];
if (method_exists($controller, $action_name_method)) {
	$controller->$action_name_method();
} else if (method_exists($controller, $action_name)) {
	$controller->$action_name();
} else {
	include PAGENOTFOUND;
}

?>