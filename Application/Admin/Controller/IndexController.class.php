<?php
namespace Admin\Controller;
class IndexController extends BaseController {
    public function index(){
        layout(false);
        $this->display();
    }
}