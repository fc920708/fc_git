<?php
/**
*BaseController.class.php文件
* ----------------------------------------------
* admin后台基本控制器，在admin模块里面必须该基本控制器
* ==============================================
* 版权所有 2015 http://www.jiuxindai.com
* ==============================================
* @date 2015-11-17
* @author:  八宝粥
*/


namespace Admin\Controller;

class BaseController extends EmptyController{

	/**
	 * @var \Admin\Model\AuthModel
	 */
	public $auth;
	//右上角按钮
	public $button_type = "链接";
	public $button_name = "";
	public $button_url = "";
	public $button_color = "";
	public $button_event = "";


	//当前用户的权限
	public $auth_rules = array();
	/**
	 * 用户uid
	 * @var int
	 */
	public $uid = 0;

	public function __construct(){
		
	
		parent::__construct();


		if( $this->checkLogin() === false){

// 			redirect('/Admin/Index/index');
		}


		//登录后设置用户信息
		$this->afterLogin();


		$this->auth = D('Auth');

		//获得登录之后 用户的用户组id
		$gid = $this->auth->getUserGroupId($this->uid);
// 		dump($gid);die;
		if(!empty($gid)){
			//获取该组权限信息
			$GroupRules = $this->auth->getGroupRule($gid);
// 			dump($GroupRules);die;
			$this->auth_rules = $GroupRules;
			$this->assign('cate_list',$GroupRules);
		}
// 		dump(__ACTION__);die;
 		//判断是否拥有权限
 		if((__ACTION__) == "/Admin/Base/index" || (__ACTION__) == "/admin/base/index"){
			
 		}else{
 			//处理控制器 方法
 			$array = split("/",(__ACTION__));
// 			dump($array);die;
 			$str = $this->strUrl($array);
// 			dump($str);die;
 			$controller = $action = str_replace($array[2],$str,(__CONTROLLER__));
 			$action = str_replace($array[2],$str,(__ACTION__));
// 			dump($action);dump($gid);die;
 			$auth = $this->auth->authAllGroup($action,$gid);
			if($auth == false){
				$this->error('对不起你没有权限');
			}
 		}

		$this->assign('current_controller',$controller);
		$this->assign('current_action',$action);

		$this->assign('session',$_SESSION);
		//右上按钮类型
		$this->assign('button_type',$this->button_type);
		
		//面包屑导航信息
		$this->assign('current_controller_title',$this->auth->getGuideTitle($controller));
		$this->assign('current_action_title',$this->auth->getGuideTitle($action));
		$module = $this->auth->getGuideTitle($controller);

	}

	/**
	 * for 子类 做一些初始化工作 会被框架自动调用
	 */
	public function _initialize()
	{
		//todo init something
	}
	
	/**
	 * url处理
	 */
	public function strUrl($array){
		$urls = split("_",$array[2]);
		$str = "";
		for($i=0;$i<count($urls);$i++){
			$str .= ucfirst($urls[$i]);
		}

		return $str;
	}

	/**
	 * 跳转用户第一个权限的界面
	 */
    public function index(){
        
		if(empty($this->auth_rules)){
			$this->error('对不起你没有权限');
		}

// 		dump($this->auth_rules);die;
		foreach($this->auth_rules as $v){
			$authUrl = '';
			foreach($v['son'] as $value){
				$authUrl = $value['name'];
				if($authUrl){

					break;
				}
			}
			if($authUrl){
				break;
			}
		}
// 		dump($authUrl);die;
		if($authUrl != ''){
			redirect($authUrl);
		}else{
			redirect('/');
		}

    }


	/**
	 * 检查是否登录 登录过了设置 用户相关id
	 *
	 * @author zhangcheng
	 * @return bool
	 */
	protected function checkLogin(){

		if( session('?uid')){

			//$this->setId(session('uid'));

			return true;
		}else{

			return false;
		}

	}

	/**
	 * 登录后设置用户信息
	 *
	 * @author zhangcheng
	 **/
	protected function afterLogin(){

		$this->setId(session('uid'));
	}


	/**
	 * 设置用户uid bid
	 *
	 * @param $uid
	 * @param $bid
	 */
	protected function setId($uid){

		$this->uid = (int)$uid;
	}


	/**
	 * 方法返回json
	 *
	 * @param int $status 返回状态码
	 * @param string $content 返回提示信息
	 * @param array|string $data 返回的数据|跳转url
	 */
	protected function actionReturn($status,$content='',$data = null)
	{
		$response['status'] = $status;
		$response['content'] = $content;
		if($data !== null && is_array($data)) {

			$response['data'] = $data;
		}

		// data为字符串时 看作是 跳转url
		if( $data !== null && is_string($data) ){
			$response['url'] = $data;
		}

		$this->ajaxReturn($response);

	}
}