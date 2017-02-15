<?php
/**
 * Created by PhpStorm.
 * User: fc
 * Date: 15-12-29
 * Time: 下午2:13
 */
namespace Admin\Controller;
class TpController extends AuthController
{
    
    /*
     * tp分页
     *
     * $page 当前页数  $model 表名  $condition 搜索条件  $order  排序条件  $num 每页展示数  $field 查询字段
     */
    function page($page,$model,$condition,$order,$num,$field){
        $UserModel = D($model);
        $data = $UserModel->where($condition)->order($order)->page($page, $num)->field($field)->select();
        $count = $UserModel->where($condition)->count();// 查询满足要求的总记录数
    
        $Page = new \Think\Page($count, $num);// 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->shows();// 分页显示输出
        $return['data'] = $data;
        $return['count'] = $count;
        $return['show'] = $show;
        return $return;
    }
}