<?php 

/**
*AuthModel.class.php文件
* ----------------------------------------------
* auth数据库模型类
* ==============================================
* 版权所有 2015 http://www.jiuxindai.com
* ==============================================
* @date 2015-11-14
* @author:  八宝粥
*/

namespace Admin\Model;

use Think\Model;

class AuthModel extends Model {
	
	public $tableName = 'auth_group_access';
	
	Public function __construct($name="",$table=""){
		$this->tableName = $table?$table:$this->tableName;
		parent::__construct();
	
	}
	
	
    /**
    * 查询所有用户所在组的信息列表
    * @author 八宝粥
    * @date 2015-11-14
    * @version v1.0.0
    */
	
	public function  getAllUserInfo(){
		
		$list = $this->field("fc_admin_user.uid,fc_admin_user.username,fc_admin_user.status,fc_admin_user.addtime,fc_auth_group.title,fc_admin_user.avatar")
		->join('fc_admin_user ON fc_admin_user.uid = fc_auth_group_access.uid')
		->join('fc_auth_group ON fc_auth_group.id = fc_auth_group_access.group_id')
		->order("addtime asc")
		->select();
		
		return  $list = $list?$list:false;
		
		
	}
	
	
	/**
	 * 获取所有用户组
	 * @author 八宝粥
	 * @date 2015-11-20
	 * @version v1.0.0
	 */
	public function getAllGroup(){
		return $this->table("fc_auth_group")->field("id,title,status")->select();
	
	}
	
	
	
    /**
    * 添加用户组
    * @author 八宝粥
    * @date 2015-11-14
    * @version v1.0.0
    */
	
	public  function  addUserGroup($title){
		$data['title'] = $title;
		$data['status'] = 1;
		$this->table("fc_auth_group");
		if($this->create($data)){
			return  $uid = $this->add();
						
		}else{
			return false;
		}
				
	}
	
	
	
    /**
    * 获取/设置用户组权限
    * @author 八宝粥
    * @date 2015-11-14
    * @version v1.0.0
    */
	
	public function  authGroup($data){
		if(!isset($data['type'])){
			return false;
		}
		
		if(trim($data['type'])=="set"){//设置用户组权限信息
			$where = array("id"=>$data['id']);
			$this->table("fc_auth_group");
			//处理规则
			$rules = explode(',',$data['rules']);
			sort($rules);
			$data['rules'] = implode(",",$rules);

			if($this->create($data)){
				$this->where($where)->save();
			}else{
				return  false;
			}
		}else{//获取用户组权限与所有权限信息
			
			$where_group = array("id"=>$data['gid']);
			$rules_ids = $this->table("fc_auth_group")->where($where_group)->getField('rules');
			
//			if(!$rules_ids){
//				return false;
//			}
			
			$group_info = $this->table("fc_auth_group")
			->field('id as gid,title as name,rules')->where($where_group)->find();

			// 用户组信息不存在 非法查询
			if(!$group_info){
				return false;
			}

			if(!$rules_ids) {
				//用户组还没有权限
				$rule_list = array();
			}else {
				$where_rules['id'] = array('in', $rules_ids);
				$where_rules['status'] = 1;
				$where_rules['is_cate'] = 1;

				$rule_list = $this->table("fc_auth_rule")
						->field("id as rid,title,condition")->where($where_rules)->select();
			}

			
			$data['group_info'] = $group_info;
			$data['group_rule_list'] = $rule_list;
			$data['all_rule'] = $this->selectAllAuthRule(0);
			
			return $data;
				
		}	
	}
	
	


    /**
    * 删除用户组
    * @author 八宝粥
    * @date 2015-11-20
    * @version v1.0.0
    */
	public  function delGroup($id){
		$this->startTrans(); 
	
		$rs1 = $this->execute("delete from fc_auth_group where id=$id");
		
		$rs2 = $this->execute("delete from fc_admin_user where uid in (select uid from fc_auth_group_access where group_id = $id )");
		
		$rs3 = $this->execute("delete from fc_auth_group_access where group_id = $id");
		
		if($rs1&&false!==$rs2&&false!==$rs3){
			$this->commit();	
			return true;			
		}else{
			$this->rollback();
			return false;
		}
	}
	
	
    /**
    * 递归获取用户授权的栏目
    * @author 八宝粥
    * @date 2015-11-17
    * @version v1.0.0
    */
	public function  getGroupRule($gid){
		$where_group = array("id"=>$gid);
		$rules_ids = $this->table("fc_auth_group")->where($where_group)->getField('rules');

		if(!$rules_ids){
			return false;
		}

		$rules_ids = explode(",",$rules_ids);
		
		return $GroupRules = $this->initGroupRules(0,$rules_ids);
		
	}
	
	
	
	
    /**
    * 排序整合用户组的权限列表
    * @author 八宝粥
    * @date 2015-11-17
    * @version v1.0.0
    */
	
	public  function  initGroupRules($cid=0,$gropu_rules_id){
		$cate_list = array();
		//查询根目录下的一级目录
		$top_cates = $this->table("fc_auth_rule")->where("type=1 and status=1 and pid=$cid and is_cate=1")->order('sort asc')->select();

		if($top_cates){
			foreach ($top_cates as $k=>$v){
				//如果该级栏目在用户组rules里面则继续
				if(in_array($v['id'],$gropu_rules_id)){
			
					$son_cate  = "";
					//获取该级栏目的子级栏目
					if($this->getSonCates($v['id'])){
			
						$son_cate = $this->initGroupRules($v['id'],$gropu_rules_id);
						$son_cate = $son_cate?$son_cate:"";
					}
					$cate_list[$k] = $v;
					$cate_list[$k]['son'] = $son_cate;
				}
				
			}		
		}
		return $cate_list;
		
		
	}
	

	
	
    /**
    * 查看用户组权限节点信息
    * @author 八宝粥
    * @date 2015-11-20
    * @version v1.0.0
    */
	public  function  selectAuthRule($id){
		return $this->table("fc_auth_rule")->where("type=1 and id = $id")->find();
	}
	
	
	
	
	
    /**
    *添加权限验证节点
    * @author 八宝粥
    * @date 2015-11-14
    * @version v1.0.0
    */	
	public function addAuthRule($data){
				
		if($this->create($data)){
			return $this->add();		
		}else{
			return  false;
		}		
	}
	
	
	
	
    /**
    * 修改权限验证节点规则
    * @author 八宝粥
    * @date 2015-11-16
    * @version v1.0.0
    */
	
	public function updateAuthRule($data){
		$where = array("id"=>$data['id']);
		if($this->create($data)){		
			
			return $this->where($where)->save();	
		}else{
			return  false;
		}
	}
	
	
    /**
    * 删除权限验证节点规则
    * @author 八宝粥
    * @date 2015-11-16
    * @version v1.0.0
    */	
	
	public  function delAuthRule($id){
		$this->table("fc_auth_rule");
		return $this->where("id=$id")->delete();
		
	}
	
	
	
    /**
    * 查询所有权限验证节点规则
    * @author 八宝粥
    * @date 2015-11-16
    * @version v1.0.0
    */
	
	public  function selectAllAuthRule($cid=0){
		$cate_list = array();
		//查询根目录下的一级目录
		$top_cates = $this->table("fc_auth_rule")->where("type=1 and  pid=$cid")->select();
		
		if($top_cates){
			foreach ($top_cates as $k=>$v){
				$son_cate  = "";
				//获取该级栏目的子级栏目
				if($this->getSonCates($v['id'])){					
					$son_cate = $this->selectAllAuthRule($v['id']);
					
				}
				$cate_list[$k] = $v;
				$cate_list[$k]['son'] = $son_cate;
			}		
		}
		return $cate_list;
	}
	
	
	
	
	
    /**
    * 检测是否有子级目录
    * @author 八宝粥
    * @date 2015-11-17
    * @version v1.0.0
    */
	
	public function getSonCates($cid){
		$has_son_cates = $this->table("fc_auth_rule")->where("type=1  and pid=$cid and is_cate=1")->count();
		
		return $has_son_cates;
	}
	
	
	
	
    /**
    * 获取导航名称
    * @author 八宝粥
    * @date 2015-11-17
    * @version v1.0.0
    */
	public function getGuideTitle($name){
		return $this->table("fc_auth_rule")->where("type=1  and name ='$name'")->getField("title");
	}


	/**
	 * 获取用户的　用户组group_id
	 * @param $uid
	 * @return mixed
	 */
	public function getUserGroupId($uid)
	{
		$group =  $this->table('fc_auth_group_access')
				->where(array('uid'=>$uid))
				->find();
		if(empty($group)){
			return false;
		}else{
			return $group['group_id'];
		}
	}


	/**
	 * 判断是否满足权限
	 * @author fc
	 * @date 2016-5-3
	 * @version v1.0.0
	 */
	public function authAllGroup($url,$gid){
		$auth = $this->table("fc_auth_rule")->where("`name`='{$url}'")->find();
		if($auth){//权限存在
	
			//查询用户权限组
			$level = $this->table("fc_auth_group")->where("`id`={$gid}")->find();
			if($level){
				//用户权限组拥有的权限
				$array = explode(",",$level['rules']);
				//return $url;
				if(in_array($auth['id'],$array)){
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
				
		}else{
			return false;
		}
	}
}



?>