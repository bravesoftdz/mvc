<?php

namespace Dykyi;

use Dykyi\Common\PostData;
use Dykyi\Common\Session;

/**
 * Interface IController
 * @package Dykyi
 */
interface IController
{
    /**
     * Index page must have
     *
     * @return mixed
     */
    public function index();

    /**
     * Render To Action
     *
     * @param $route
     * @param $params
     * @return mixed
     */
    public function render($route, array $params);

    /**
     * Render View Page
     *
     * @param $view
     * @param array $params
     * @return mixed
     */
    public function view($view, array $params);

}

/**
 * Class AbstractController
 * @package Dykyi
 */
abstract class AbstractController implements IController
{
    protected $action;
    protected $route;
    protected $layout = 'main';
    protected $view;

    protected $post;
    protected $session;
	
    protected $message = '';

    function __construct()
    {
        $this->post    = new PostData();
        $this->session = new Session();
    }

    /**
     * @param $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * @param $route
     */
    public function setRoute($route)
    {
        $this->route = $route;
    }

    /**
     * @param $file
     *
     * @return string
     */
    private function _requireToVar($file){
        ob_start();
        require($file);
        return ob_get_clean();
    }

    /**
     * @param string $view
     * @param array $params
     * @return mixed
     */
    public function view($view = '', array $params = [])
    {
        foreach ($params as $var => $value) {
            $this->$var = $value;
        }

        $view = empty($view) ? $this->route.'/'.$this->action : $view;
        $this->view = $this->_requireToVar(ROOT_DIR.'/views/' . $view . '.php');
        return require_once(ROOT_DIR.'/views/layout/' . $this->layout . '.php');
    }

    /**
     * @param $name
     */
    public function setLayout($name)
    {
        $this->layout = $name;
    }

    /**
     * Respons to ajax
     *
     * @param $data
     * @return bool
     */
    public function json($data)
    {
        echo json_encode($data);
        return true;
    }

    /**
     * @param $route
     * @param $params
     * @return bool
     */
    public function render($route = '', array $params = [])
    {
        foreach ($params as $key => $value) {
            $this->session->set($key, $value);
        }

        header('Location: /' . $route);
        return true;
    }

    /**
     * @return mixed|string
     */
    public function getGlobalMessage()
    {
        $message = $this->session->get('message');
        $this->session->remove('message');
        return $message;
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
        die();
    }


}