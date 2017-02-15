<?php
/**
 * Created by PhpStorm.
 * User: zc
 * Date: 2015/11/23
 * Time: 11:57
 */

namespace Admin\Model;


class UserModel extends CommonModel
{
	protected $tableName = 'admin_user';
	
    protected $_validate = array(
        array('username', '1,100', '用户名称长度必须在1-100', self::EXISTS_VALIDATE, 'length', self::MODEL_BOTH),
        array('avatar', '0,255', '用户头像url长度必须在0-255', self::EXISTS_VALIDATE, 'length', self::MODEL_BOTH),

    );

    protected $_auto = array(
        array('addtime', 'time', self::MODEL_INSERT, 'function'),

    );


    /**
     * 添加后台新用户
     *
     * @param $data array 新用户数据
     *
     * @return int 新用户uid 失败返回 0
     */
    public function addUser($data)
    {


        if (!$this->create($data)) {

            return 0;

        } else {

            $this->startTrans();

            $uid = $this->add();

            if (false === $uid) {
                $this->rollback();

                return 0;
            } else {

                //添加用户的 用户组
                $auth = M('auth_group_access');

                if (!$auth->create(array('uid' => $uid, 'group_id' => $data['group_id']))) {
                    $this->rollback();
                    return 0;
                } else {

                    $row = $auth->add();

                    if ($row) {
                        $this->commit();

                        return $uid;
                    } else {
                        $this->rollback();
                        return 0;
                    }
                }


            }
        }

    }

    /**
     * 更新用户信息 包括 用户与用户组关系
     *
     * @param $data
     *
     * @return bool
     */
    public function updateUser($data)
    {

        if (!isset($data['uid'])) {

            return false;
        }

        $this->startTrans();

        $where = array('uid' => $data['uid']);

        $result = $this->where($where)
            ->field('username,password,avatar,status')
            ->save($data);

        if (false === $result) {
            $this->rollback();
            return false;
        } else {

            //更新 用户用户组信息
            $auth = M('auth_group_access');
            $row = $auth->where(array('uid' => $data['uid']))
                ->field('group_id')
                ->save($data);

            if (false === $row) {
                $this->rollback();
                return false;
            } else {
                $this->commit();

                return true;
            }
        }

    }


    /**
     * 删除用户 同时清除用户与用户组关联表信息
     *
     * @param $uid int 用户uid
     *
     * @return bool
     */
    public function delUser($uid)
    {
        $this->startTrans();

        $row = $this->where(array('uid' => $uid))->delete();

        if ($row === 0) {
            $this->rollback();
            return false;
        }

        //删除用户组权限表
        $auth = M('auth_group_access');

        $delNum = $auth->where(array('uid' => $uid))
            ->delete();

        if ($delNum === 0) {
            $auth->rollback();
            return false;
        }

        $auth->commit();

        return true;


    }


    /**
     * 查找单个用户信息 以及 所属用户组信息
     *
     * @param $uid 用户uid
     *
     * @return mixed
     */
    public function getUserinfoByUid($uid)
    {

        $result = $this->field('jt_admin_user.uid,jt_admin_user.username,jt_admin_user.avatar,jt_admin_user.status,jt_auth_group_access.group_id')
            ->join('jt_auth_group_access ON jt_admin_user.uid = jt_auth_group_access.uid')
            ->where(array('jt_admin_user.uid'=>$uid))
            ->find();

        return $result;
    }

    /**
     * 取得后台用户账号信息
     * @param $username
     * @return mixed
     */
    public function getUserByName($username)
    {
        return $this->where(array('username'=>$username))->find(); 
    }
}