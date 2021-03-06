<?php

namespace Dykyi;

$pos              = strripos($_SERVER['DOCUMENT_ROOT'], '/');
$documentRootPath = mb_strcut($_SERVER['DOCUMENT_ROOT'], 0, $pos);
define('ROOT_DIR', $documentRootPath);

$_ENV = 'dev';

require_once '../vendor/autoload.php';

session_start();

error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 1);

/**
 * @param $param
 * @return null
 */
function getUrlParam($param)
{
    return empty($param) ? null : $param;
}

$uri = substr($_SERVER['REQUEST_URI'], 1);
$pos = strpos($uri, "?");
if ($pos > 0) {
    $uri = substr($uri, 0, $pos);
}
$uri       = explode('/', $uri);
$route     = empty($uri[0]) ? 'index' : $uri[0];
$action    = empty($uri[1]) ? 'index' : $uri[1];
$arguments = [];
for ($i = 2; $i < count($uri); $i++) {
    $arguments[$i] = getUrlParam($uri[$i]);
}

$className = __NAMESPACE__ . "\\Controller\\" . ucfirst($route) . 'Controller';
$class     = new $className();
$class->setAction($action);
$class->setRoute($route);

set_error_handler([$class, "myErrorHandler"]);

$fct  = new \ReflectionMethod($className, $action);
if ($fct->getNumberOfRequiredParameters() > 0){
    $class->$action(...$arguments);
} else{
    $class->$action();
}

exit();