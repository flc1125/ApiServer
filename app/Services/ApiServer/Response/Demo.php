<?php
namespace App\Services\ApiServer\Response;

/**
 * api测试类
 * @author Flc <2016-7-31 13:44:07>
 */
class Demo extends BaseResponse implements InterfaceResponse
{
    /**
     * 接口名称
     * @var string
     */
    protected $method = 'demo';

    /**
     * 执行接口
     * @param  array &$params 请求参数
     * @return array          
     */
    public function run(&$params)
    {
        return [
            'status' => true,
            'code'   => '200',
            'data'   => [
                'current_time' => date('Y-m-d H:i:s')
            ]
        ];
    }
}