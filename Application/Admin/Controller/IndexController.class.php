<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Common\Constants\MessageConstants;
use Admin\Common\Constants\NumberConstants;

class IndexController extends Controller
{

    protected function _initialize()
    {
        layout(false);
    }

    //µÇÂ¼
    public function index()
    {
        if(session('?uid')){
//             redirect('/Admin/Base/index');
        }
        if(IS_GET) {
//             dump(session());
            $this->display();
        }else{
            $username = I('post.username');
            $password = I('post.password');

            $userModel = D('User');
            //dump($userModel);
            $userInfo = $userModel->getUserByName($username);
//             dump($userModel->where("username='".$username."'")->find());die;
            if(empty($userInfo)) {
                $response['status'] = NumberConstants::ACTION_ERROR;
                $response['content'] = MessageConstants::ADMIN_LOGIN_USER_NOT_EXISTS;
                $this->ajaxReturn($response);
            }elseif($userInfo['status'] != 1){
                $response['status'] = NumberConstants::ACTION_ERROR;
                $response['content'] = MessageConstants::ADMIN_LOGIN_USER_STATUS_ERROR;
                $this->ajaxReturn($response);

            }elseif(md5($userInfo['password']) != md5($password)) {
                $response['status'] = NumberConstants::ACTION_ERROR;
                $response['content'] = MessageConstants::ADMIN_LOGIN_PWD_ERROR;
                $this->ajaxReturn($response);
            }else{
                $response['status'] = NumberConstants::ACTION_SUCCESS;
                $response['content'] = MessageConstants::ADMIN_LOGIN_SUCCESS;
                $response['url'] = '/Admin/Base/index';
                   
                //ÉèÖÃµÇÂ¼
                session('uid',$userInfo['uid']);
                session('username',$userInfo['username']);

                $this->ajaxReturn($response);
            }

        }
    }

    public function logout()
    {
        session(null);
        cookie(null);
        redirect('/Admin');
    }


    public function test()
    {
//        session('aaaaa',1);
//        //sleep(5);
//        echo session('aaaaa');

        dump($_SESSION);
    }





}
