<?php
/**
 * Created by PhpStorm.
 * User: zc
 * Date: 2015/11/23
 * Time: 9:33
 */

namespace Admin\Common\Constants;

/**
 * Class MessageConstants 提示信息常量定义
 *
 * @package Admin\Common\Constants
 */
class MessageConstants
{
    /**
     * 插件删除成功返回消息
     *
     * @const string
     */
    const PLUGIN_DEL_SUCCESS = '删除成功';
    /**
     * 插件删除失败返回消息
     *
     * @const string
     */
    const PLUGIN_DEL_FAILURE = '删除失败';

    /**
     * 插件添加成功返回消息
     *
     * @const string
     */
    const PLUGIN_CREATE_SUCCESS = '新增插件成功';

    /**
     * 插件添加失败返回消息
     *
     * @const string
     */
    const PLUGIN_CREATE_FAILURE = '新增插件失败';

    /**
     * 插件修改成功返回消息
     *
     * @const string
     */
    const PLUGIN_UPDATE_SUCCESS = '修改插件成功';

    /**
     * 插件修改失败返回消息
     *
     * @const string
     */
    const PLUGIN_UPDATE_FAILURE = '修改插件失败';

    /**
     * 删除用户成功返回消息
     *
     * @const string
     */
    const USER_DEL_SUCCESS = '删除用户成功';

    /**
     * 删除用户失败返回消息
     *
     * @const string
     */
    const USER_DEL_FAILURE = '删除用户失败';

    /**
     * 添加用户成功返回消息
     *
     * @const string
     */
    const USER_ADD_SUCCESS = '添加用户成功';

    /**
     * 添加用户失败返回消息
     *
     * @const string
     */
    const USER_ADD_FAILURE = '添加用户失败';

    /**
     * 更新用户成功返回消息
     *
     * @const string
     */
    const USER_UPDATE_SUCCESS = '更新用户信息成功';

    /**
     * 更新用户失败返回消息
     *
     * @const string
     */
    const USER_UPDATE_FAILURE = '更新用户信息失败';


    /**
     * 更新用户组权限成功 返回消息
     *
     * @const string
     */
    const AUTH_GROUP_UPDATE_SUCCESS = '更新用户组权限成功';

    /**
     * 更新用户组权限失败 返回消息
     *
     * @const string
     */
    const AUTH_GROUP_UPDATE_FAILURE = '更新用户组权限失败';


    const KANJIA_CREATE_SUCCESS = '添加活动成功';

    const KANJIA_CREATE_FAILURE = '添加活动失败';

    const KANJIA_UPDATE_SUCCESS = '更新砍价活动成功';

    const KANJIA_UPDATE_FAILURE = '更新砍价活动失败';

    const KANJIA_DEL_SUCCESS = '删除砍价活动成功';

    const KANJIA_DEL_FAILURE = '删除砍价活动失败';

    const KANJIA_UPDATE_REWARD_SUCCESS = '修改发放奖励状态成功';
    const KANJIA_UPDATE_REWARD_FAILURE = '修改发放奖励状态失败';

    const KANJIA_REG_USER_SUCCESS = '注册成功';
    const KANJIA_REG_USER_REPEAT_FAILURE = '注册失败,用户已注册';
    const KANJIA_REG_USER_FAILURE = '注册失败,添加用户数据失败';


    const ADMIN_LOGIN_USER_NOT_EXISTS = '后台用户名不存在';
    const ADMIN_LOGIN_PWD_ERROR = '登录密码错误';
    const ADMIN_LOGIN_SUCCESS = '登录成功';
    const ADMIN_LOGIN_USER_STATUS_ERROR = '用户名无效';

    //PRODUCT
    const PRODUCT_MONEY_LIMIT_ERROR = '项目总金额不能超过20亿';
    const PRODUCT_TIME_LIMIT_ERROR = '非活期借款期限不为0';
}