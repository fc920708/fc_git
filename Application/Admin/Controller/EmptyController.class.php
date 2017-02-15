<?php
/**
 * 空控制器
 * Created by PhpStorm.
 * User: 八宝粥
 * Date: 2015/11/13
 * Time: 15:46
 */
namespace Admin\Controller;

use Think\Controller;

class EmptyController extends Controller
{
    public function _empty()
    {
        layout(false);
        send_http_status(404);
        $this->display('Public:404');
        exit;

    }

    public function index()
    {
        layout(false);
        send_http_status(404);
        $this->display('Public:404');

    }

}