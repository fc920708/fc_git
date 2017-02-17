<?php
/**
 * Created by PhpStorm.
 * User: zc
 * Date: 2015/11/23
 * Time: 9:36
 */

namespace Admin\Common\Constants;
if(version_compare(PHP_VERSION,'5.6.0','<')) {
    die('Admin\Common\Constants\NumberConstants require PHP > 5.6.0 !');
}
/**
 * Class NumberConstants 数字常量定义
 *
 * @package Admin\Common\Constants
 */
class NumberConstants
{
    /**
     * 操作成功码
     *
     * @const int
     */
    const ACTION_SUCCESS = 1;

    /**
     * 操作失败码
     *
     * @const int
     */
    const ACTION_ERROR = 0;


    /**
     * ajax返回成功码
     * @const int
     */
    const AJAX_STATUS_SUCCESS = 1;

    /**
     * ajax返回错误码
     * @const int
     */
    const AJAX_STATUS_ERROR = 0;


    //PRODUCT 产品
    const PRODUCT_MONEY_LIMIT = 2000000000;// 单笔产品 20亿限制

    const PRODUCT_TYPE_PLAN = 0 ;// 产品类型 卫士计划类型 债权
    const PRODUCT_TYPE_CAR = 1;//产品类型 玖承车项目
    const PRODUCT_TYPE_HOME = 2;//产品类型 玖承房项目
    const PRODUCT_TYPE_NEW = 3;//产品类型 玖承房项目

    const PRODUCT_TYPE_ARRAY = array( //类型号 对应 类型名称
        0=>'卫士计划',
        1=>'玖承车项目',
    	2=>'玖承房项目',
        3=>'新手标',
    );
    const PRODUCT_TYPE_ARRAY_ALLOW = array( //允许投资的产品类型
        self::PRODUCT_TYPE_PLAN,
        self::PRODUCT_TYPE_CAR,
        self::PRODUCT_TYPE_HOME,
        self::PRODUCT_TYPE_NEW,
    );

    const PRODUCT_EARN_TYPE_MONTH = 0;//产品 收益类型 按月
    const PRODUCT_EARN_TYPE_DAY = 1;//产品 收益类型 按日
    const PRODUCT_EARN_TYPE_ARRAY = array(
        0=>'按月还款',
        1=>'按日还款',
    );


    const PRODUCT_COMPACT_TYPE_PLAN = 0;//产品 合同类型 卫视计划类型合同
    const PRODUCT_COMPACT_TYPE_ACTIVE = 1;//产品 合同类型 活期类型
    const PRODUCT_COMPACT_TYPE_ARRAY = array(
        0=>'卫士计划',
        1=>'玖承车项目',
        2=>'玖承房项目',
        3=>'新手标',
    );


    //虚拟货币
    const VIRTUAL_MONEY_TYPE_RED = 0;//红包 类型值
    const VIRTUAL_MONEY_TYPE_CREDIT = 1;//代金券
    const VIRTUAL_MONEY_TYPE_ARRAY = array( // 类型值对应名称
        0=>'代金券',//原来红包
        1=>'红包',
    );
    const VIRTUAL_MONEY_TYPES = array( //虚拟货币所有类型
        self::VIRTUAL_MONEY_TYPE_RED,
        self::VIRTUAL_MONEY_TYPE_CREDIT,
    );
    const VIRTUAL_MONEY_CAN_CONVERT_USE_MONEY = array( //可在最后一次收益中 被加入到 用户可用金额中的 虚拟货币 配置
        self::VIRTUAL_MONEY_TYPE_RED,
    );



    //产品审核状态
    const PRODUCT_STATUS_NOT_CAT = 0;//刚发布 未审核的
    const PRODUCT_STATUS_ALLOW = 1;// 审核通过
    const PRODUCT_STATUS_NOT_ALLOW = 2;//审核未通过

    //合同状态  废弃 交易之后 直接能下载
    const TRADE_CONTRACT_STATUS_NO = 0;//合同未创建
    const TRADE_CONTRACT_STATUS_CREATE = 1;//合同已创建 未审核通过
    const TRADE_CONTRACT_STATUS_PASS = 2;//通过审核

}