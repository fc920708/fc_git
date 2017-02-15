<?php
namespace Admin\Controller;
class IndexController extends Controller {
    public function index(){
        layout(false);
        $this->display();
    }
}