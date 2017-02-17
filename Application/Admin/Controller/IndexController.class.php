<?php
namespace Admin\Controller;
// use Think\Controller;
class IndexController extends BaseController {
    public function index(){
        layout(false);
        $this->display();
    }
}