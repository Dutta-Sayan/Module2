<?php

require_once('./Route.php');

// Requested URI.
$uri = $_SERVER['REQUEST_URI'];

// Storing the uri as array to get the routed path
$url = explode("/", $uri);

// Object of route class.
$route = new Route();

// Checking different routes for different paths.
switch ($url[1])
{
  case '':
  case '/':
      $route->anonymousDashboard();
      break;

  case 'admin':
  case 'login':
      $route->login();
      break;

  case 'register':
      $route->register();
      break;

  case 'logout':
      $route->logout();
      break;
  
  default :
      $route->pageNotFound();
      break;

}
