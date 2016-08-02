<?php
namespace App\Services\ApiServer\Response;

/**
 * api接口类
 * @author Flc <2016-7-31 13:44:19>
 */
Interface InterfaceResponse
{
    /**
     * 执行接口
     * @return array 
     */
    public function run(&$params);

    /**
     * 返回接口名称
     * @return string 
     */
    public function getMethod();
}