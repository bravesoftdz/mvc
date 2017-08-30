<?php

namespace Dykyi\Common;

/**
 * Interface IGetData
 * @package Dykyi\Common
 */
interface IGetData
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
 * Class GetData
 * @package Dykyi\Common
 */
class GetData implements IGetData
{

    public function get($key = '')
    {
        if ($key == ''){
            return $_GET;
        }
        return empty($_GET[$key]) ? '' : $_GET[$key];
    }

}