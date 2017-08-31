<?php

namespace Dykyi\Common;

/**
 * Interface IPostData
 * @package Dykyi\Common
 */
interface IPostData
{
    /**
     * Get post value
     *
     * @param $key
     * @return mixed
     */
    public function get($key);
}

/**
 * Class PostData
 * @package Dykyi\Common
 */
class PostData implements IPostData
{
    private $data = [];

    public function __construct()
    {
        $this->data = $_POST;
    }

    public function get($key = '')
    {
        if ($key == ''){
            return $this->data;
        }
        return empty($this->data[$key]) ? '' : $this->data[$key];
    }

}