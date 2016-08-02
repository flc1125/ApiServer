<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ApiServer\Server;
use App\Services\ApiServer\Error;

/**
 * Api入口控制器
 * @author Flc <2016-7-31 10:16:42>
 */
class RouterController extends Controller
{
    /**
     * API总入口
     * @return [type] [description]
     */
    public function index()
    {
        $server = new Server(new Error);
        return $server->run();
    }
}
