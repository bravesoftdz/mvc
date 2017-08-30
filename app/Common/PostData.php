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

    public function get($key = '')
    {
        if ($key == ''){
            return $_POST;
        }
        return empty($_POST[$key]) ? '' : $_POST[$key];
    }

}