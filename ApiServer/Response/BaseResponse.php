<?php
namespace App\Services\ApiServer\Response;

/**
 * api基础类
 * @author Flc <2016-7-31 13:44:07>
 */
abstract class BaseResponse
{
    /**
     * 接口名称
     * 
     * @var [type]
     */
    protected $method;

    /**
     * 返回接口名称
     * @return string 
     */
    public function getMethod()
    {
        return $this->method;
    }
}