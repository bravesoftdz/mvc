<?php

namespace Dykyi\Controller;

use Dykyi\AbstractController;
use Dykyi\Model\UsersModel;

/**
 * Class IndexController
 * @package Dykyi
 *
 * @property UsersModel $userModel
 */
class IndexController extends AbstractController
{
    protected $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new UsersModel();
    }

    public function index()
    {
        return $this->view('index', ['users' => $this->userModel->getAll()]);
    }

    public function test($var1, $var2)
    {
        echo $var1 . ' ' . $var2;
    }
}
