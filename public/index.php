<?php

namespace Dykyi;

define('ROOT_DIR', $_SERVER['DOCUMENT_ROOT']);

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

/**
 * Error process function
 *
 * @param $err_type
 * @param $err_msg
 * @param $err_file
 * @param $err_line
 * @return bool
 */
function myErrorHandler($err_type, $err_msg, $err_file, $err_line)
{
    static $count = 0;
    $count++;
    echo "<div style=\"width:32px; height:32px; float:left; margin:0 12px 12px 0;\"></div>"
        ."<b>Error №$count:</b><p>Sorry, but there was an error on this page. "
        ."Please send the following message to the site administrator on the page <a href='#'>help</a>.</p>"
        ."<p>Error type: <em>$err_type</em>, messsage: <em>$err_msg</em>, file: <em>$err_file</em>, line number: <em>$err_line</em>"
        ."<hr color='red'>";
    return true;
}
set_error_handler("myErrorHandler");

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

$className = __NAMESPACE__ . "\\Controller\\Controller" . ucfirst($route);
$class     = new $className();
$class->setAction($action);
$class->setRoute($route);

$fct  = new \ReflectionMethod($className, $action);
if ($fct->getNumberOfRequiredParameters() > 0){
    $class->$action(...$arguments);
} else{
    $class->$action();
}

exit();
