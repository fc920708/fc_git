<?php
/**
 *AuthController.class.php文件
 * ----------------------------------------------
 * 用户权限管理文件
 * ==============================================
 * 版权所有 2015 http://www.jiuxindai.com
 * ==============================================
 * @date 2015-11-14
 * @author:  八宝粥
 */


namespace Admin\Controller;
use Think\Controller;
use Admin\Common\Constants\MessageConstants;
use Admin\Common\Constants\NumberConstants;


class AuthController extends Controller {
	
	public  $Auth_D;
	
	Public function __construct(){
		parent::__construct();
	
	}
	
	
	
    /**
    * 用户信息列表
    * @author 八宝粥
    * @date 2015-11-14
    * @version v1.0.0
    */
    public function index(){
    	$uid = 1;
    	
    	$list = $this->auth->getAllUserInfo();
    	
    	//$group = $this->auth->authGroup(array("type"=>"get","gid"=>1));
    	
    	//$rules = $this->auth->authGroup(array("type"=>"set","gid"=>1)); 
    	//
    	//var_dump($list);
    	
    	
    	
    	$this->assign('list',$list);
    	$this->display("index");
    }
    
    

    /**
    * 获取所有权限列表
    * @author 八宝粥
    * @date 2015-11-18
    * @version v1.0.0
    */
    
    public function getRules(){
    	//右上角按钮
    	$this->button_name = "新增权限";
    	$this->button_url = "/addRules";

    	$get_all_rule = $this->auth->selectAllAuthRule();
    	
    	$this->assign('get_all_rule',$get_all_rule);
    	$this->assign("button_name",$this->button_name);
    	$this->assign("button_url",strtolower(__CONTROLLER__).$this->button_url);
  
    	$this->display('getRules');
    	
    }
    
    

    /**
    * 查看用户组权限
    * @author 八宝粥
    * @date 2015-11-23
    * @version v1.0.0
    */
    public function getGroupRules(){
    	if(IS_GET){
    		$id = I("get.id",0) + 0 ;
    		$data = array("gid"=>$id,"type"=>"get");
    		$getGroupRules = $this->auth->authGroup($data);
    		    		
    		$this->assign("getGroupRules",$getGroupRules);
    		$this->display('getGroupRules');
    		
    	}else{
			$rule = array();

			//过滤未选择的权限 值为0
			foreach($_POST['real_rules'] as $v){

				$val = (int) $v;
				if($val == 0 ){
					continue;
				}else{
					$rule[] = $val;
				}
			}

			$data['id'] = I('post.gid',0,'int');
			$data['rules'] = join(',',$rule);
			$data['type'] = 'set';


			$auth = new \Admin\Model\AuthModel('','auth_group');
			$result = $auth->authGroup($data);

			if($result !== false){
				$response['status']  = NumberConstants::ACTION_SUCCESS;
				$response['content'] = MessageConstants::AUTH_GROUP_UPDATE_SUCCESS;
				$response['url'] = '/Admin/Auth/getAllGroup';
			}else{
				$response['status']  = NumberConstants::ACTION_ERROR;
				$response['content'] = MessageConstants::AUTH_GROUP_UPDATE_FAILURE;
				$response['url'] = '';
			}

			$this->ajaxReturn($response);
    		
    		
    	}	
    }
    
    
    
    /**
    * 添加权限
    * @author 八宝粥
    * @date 2015-11-19
    * @version v1.0.0
    */
    
    public function addRules(){
    	
    	if(IS_POST){
    		$data = I("post.");
    		$data['status'] = 1;
    		
    		$this->Auth_D = new \Admin\Model\AuthModel("","auth_rule");
    		
    		$rs = $this->Auth_D->addAuthRule($data);
    		if($rs){
    			$data['status']  = 1;
    			$data['content'] = '新增权限成功';
    			$data['url'] = '/Admin/Auth/getRules';
    		}else{
    			$data['status']  = 0;
    			$data['content'] = '新增权限失败';
    			$data['url'] = '';
    		}
    		
    		$this->ajaxReturn($data);
    	}else{
    		$get_all_rule = $this->auth->selectAllAuthRule();
    		$this->assign("get_all_rule",$get_all_rule);
    		
    		$this->display("addRules");
    	}  	
    }
    
    
    
    /**
    * 修改权限信息
    * @author 八宝粥
    * @date 2015-11-20
    * @version v1.0.0
    */
    public function updateRule(){
    	if(IS_GET){
    		$id = I("get.id",0) + 0;
    		
    		//右上角按钮
    		$this->button_type = "按钮";
    		$this->button_name = "删除权限";
    		$this->button_color  = "btn-danger";
    		$this->button_event = "deleteRules($id)";
    		$this->button_url = "/deleteRules";
    		
    		$get_all_rule = $this->auth->selectAllAuthRule();
    		
    		$selectAuthRule = $this->auth->selectAuthRule($id);

			if(empty($selectAuthRule)){
				$this->_empty();
			}

			//如果是根目录不显示
			$isRoot = call_user_func(function() use ($id,$get_all_rule){
				foreach($get_all_rule as $v){
					if($id == $v['id']){
						return true;
					}
				}
				return false;
			});

			//根目录的情况下只能选 根目录
			if($isRoot == false) {
				$this->assign("get_all_rule",$get_all_rule);
			}
    		$this->assign("selectAuthRule",$selectAuthRule);
    		
    		
    		//按钮设置
    		$this->assign("button_type",$this->button_type);
    		$this->assign("button_color",$this->button_color);
    		$this->assign("button_name",$this->button_name);
    		$this->assign("button_event",$this->button_event);
    		$this->assign("button_url",strtolower(__CONTROLLER__).$this->button_url);
    		
    		$this->display('updateRule');
    	}else{
    		$this->Auth_D = new \Admin\Model\AuthModel("","auth_rule");
    		$rs = $this->Auth_D->updateAuthRule(I("post."));
//     		dump($rs);dump(I('post.'));die;
    		if(false!==$rs){
    			$data['status']  = 1;
    			$data['content'] = '修改权限信息成功';
    			$data['url'] = '/Admin/Auth/getRules';
    		}else{
    			$data['status']  = 0;
    			$data['content'] = '修改权限信息失败';
    			$data['url'] = '';
    		}
    		 
    		$this->ajaxReturn($data);
    	}
    }
    
    
    
    /**
    * 删除权限
    * @author 八宝粥
    * @date 2015-11-20
    * @version v1.0.0
    */    
    public  function deleteRules(){
    	$id = I("post.id",0)+0;
    	
    	$rs = $this->auth->delAuthRule($id);
    	
    	if(false!==$rs){
    			$data['status']  = 1;
    			$data['content'] = '删除权限信息成功';
    			$data['url'] = '/Admin/Auth/getRules';
    	}else{
    			$data['status']  = 0;
    			$data['content'] = '删除权限信息失败';
    			$data['url'] = '';
    	}
    		 
    	$this->ajaxReturn($data);
    }
    
    
    /**
    * 查看用户组
    * @author 八宝粥
    * @date 2015-11-20
    * @version v1.0.0
    */    
    
    public  function getAllGroup(){
    	
    	$getAllGroup = $this->auth->getAllGroup();
    	$this->assign("getAllGroup",$getAllGroup);
    	
    	$this->display('getAllGroup');
    }
    

    /**
    * 新增用户组
    * @author 八宝粥
    * @date 2015-11-20
    * @version v1.0.0
    */
    public  function addGroup(){
    	if(IS_GET){
    		$this->display('addGroup');
    	}else{
    		$this->Auth_D = new \Admin\Model\AuthModel("","auth_group");
    		$rs = $this->Auth_D->addUserGroup(I("post.title"));
    		if($rs){
    			$data['status']  = 1;
    			$data['content'] = '新增用户组成功';
    			$data['url'] = '/Admin/Auth/getAllGroup';
    		}else{
    			$data['status']  = 0;
    			$data['content'] = '新增用户组失败';
    			$data['url'] = '';
    		}
    		 
    		$this->ajaxReturn($data);
    	}
    	
    }
    
    


    /**
    * 删除用户组
    * @author 八宝粥
    * @date 2015-11-20
    * @version v1.0.0
    */
    public function delGroup(){
    	$gid = I("post.gid",0)+0;
    	
    	$rs = $this->auth->delGroup($gid);
    	
    	if($rs){
    		$data['status']  = 1;
    		$data['content'] = '删除用户组成功';
    		$data['url'] = '/Admin/Auth/getAllGroup';
    	}else{
    		$data['status']  = 0;
    		$data['content'] = '删除用户组失败';
    		$data['url'] = '';
    	}
    	 
    	$this->ajaxReturn($data);
    }
    
    /**
     * 后台用户
     * @author fc
     * @date 2015-11-20
     * @version v1.0.0
     */
    public function user(){
        $list = M("admin_user")->select();
        foreach ($list as $k=>$v){
            $group_id[$k]['group_id'] = M("auth_group_access")->where(array("uid"=>$v['uid']))->getField("group_id");
            $list[$k]['title'] = M("auth_group")->where(array('id'=>$group_id[$k]['group_id']))->getField("title");
        }
        $this->assign("data",$list);
        $this->display('user');
    }
    
    /**
     * 添加用户
     * @author fc
     * @date 2015-11-20
     * @version v1.0.0
     */
    public function addUser(){
       $this->rule();
       if($_POST){
           $data['addtime'] = time();
           $data['username'] = I("post.username");
           $data['password'] = I("post.password");
           $data['status'] = I("post.status");
           $add = M("admin_user")->add($data);
           if($add){
               $msg['uid'] = $add;
               $msg['group_id'] = I("post.group_id");
               M("auth_group_access")->add($msg);
               $datas['status']  = 1;
               $datas['content'] = '添加用户成功';
               $datas['url'] = '/Admin/Auth/User';
           }else{
               $datas['status']  = 0;
               $datas['content'] = '添加用户失败';
               $datas['url'] = '';
           }
           $this->ajaxReturn($datas);
       }else{
           $this->display();
       }
    }

    /**
     * 编辑用户
     * @author fc
     * @date 2015-11-20
     * @version v1.0.0
     */
    public function editUser(){
        $this->rule();
        $id = I('get.id');
        $model = M("admin_user");
        if($_POST){
            $data['username'] = I("post.username");
            $data['password'] = I("post.password");
            $data['status'] = I("post.status");
            $save = M("admin_user")->where(array("uid"=>$id))->save($data);
            if($save === false){
                $datas['status'] = 0;
                $datas['content'] = '编辑用户失败';
                $datas['url'] = '';
            }else{
                $msg['group_id'] = I("post.group_id");
                M("auth_group_access")->where(array("uid"=>$id))->save($msg);
                $datas['status'] = 1;
                $datas['content'] = '编辑用户成功';
                $datas['url'] = '/Admin/Auth/User';
            }
            $this->ajaxReturn($datas);
        }else{
            $list = M("admin_user")->where(array("uid"=>$id))->find();
            $list['group_id'] = M("auth_group_access")->where(array("uid"=>$list['uid']))->getField("group_id");
            $this->assign("list",$list);
            $this->display('addUser');
        }
    }
    
    /**
     * 删除用户
     * @author fc
     * @date 2015-11-20
     * @version v1.0.0
     */
    public function delUser(){
        $id = I("post.id",0)+0;
        if($id == 1){
            $id = 0;
        }
        $del = M("admin_user")->where(array('uid'=>$id))->delete();
         
        if($del){
            $data['status']  = 1;
            $data['content'] = '删除用户成功';
            $data['url'] = '/Admin/Auth/User';
        }else{
            $data['status']  = 0;
            $data['content'] = '删除用户失败';
            $data['url'] = '';
        }
    
        $this->ajaxReturn($data);
    }
    
    function rule(){
        $access = M("auth_group_access")->where(array("uid"=>session("uid")))->find();
        if($access['group_id'] != 1){
            $where['id'] = array("neq",1);
        }else{
            $where = "";
        }
        $group = M("auth_group")->where($where)->select();
        $this->assign("rule",$group);
    }
}