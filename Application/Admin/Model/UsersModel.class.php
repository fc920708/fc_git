<?php
/**
 * Created by PhpStorm.
 * User: kida
 * Date: 15-12-30
 * Time: 上午9:56
 */

namespace Admin\Model;
use Think\Model;


class UsersModel extends  Model
{
    public $tableName = 'user';

    /***
     * @return mixed
     *
     * @create 2016-1-20
     *
     * @param post 数组
     *
     * @author lipengfu
     *
     *  search 统计中心数据
     */
    public function regnums($search = '')
    {


        if (!empty($search)) {
            $addtime = strtotime($search['addtime']);
            $endtime = strtotime($search['endtime']);

            $month = $this->regInvestTime($addtime);//x轴时间坐标

            //判断时间
            if (!empty($addtime) && empty($endtime)) {


                $where1 = 'addtime>=' . $addtime;
                $where2 = 'add_time>=' . $addtime;
            }

            if (!empty($endtime) && empty($addtime)) {

                $where1 = 'addtime<=' . $endtime;
                $where2 = 'add_time<=' . $endtime;

            }

            if (!empty($addtime) && !empty($endtime)) {

                $where1 = 'addtime>=' . $addtime . ' and addtime <=' . $endtime;
                $where2 = 'add_time>=' . $addtime . ' and add_time <=' . $endtime;

            }

            if (empty($addtime) && empty($endtime)) {
                foreach ($month as $k => $v) {

                    if ($v['month'] == date('Y-m', $addtime)) {
                        $where1 = 'addtime >=' . $v['firstday'] . ' and addtime <=' . $v['lastday'];
                        $where2 = 'add_time >=' . $v['firstday'] . ' and add_time <=' . $v['lastday'];
                    }


                }

            }


            //每个注册月人数

            $registers = M('user')->field('count(user_id) as users')->where($where1)->select();

            //每个月投资总金额 及 投资人数

            $sumMoney = M('trade')->field('sum(total_money) as moneys,count(user_id) as userid')->where($where2)->select();
            //遍历获取到的注册数据
            foreach ($registers as $key => $value) {

                $regs[] = $value['users'];

            }
            //遍历获取到的投资数据
            foreach ($sumMoney as $key => $value) {

                $countMoney[] = $value['moneys'];
                $countuid[] = $value['userid'];

            }

            $data1['month'] = $month;
            $data1['regster'] = $regs;
            $data1['sumTotalMoney'] = $countMoney;
            $data1['countInvestUid'] = $countuid;


            return $data1;


        } else {

            $data = $this->totalMoney();
            return $data;
        }


    }


    public function getthemonth()

    {
        //获取当前年月的时间时间戳
        for ($i = 1; $i <= 12; $i++) {
            $times = date('Y') . '-' . $i . '-1';
            $datas[] = strtotime($times);
        }


        foreach ($datas as $k => $v) {

            $firstday = date('Y-m-01', $v);
            $lastday = date('Y-m-d', strtotime("$firstday +1 month -1 day"));
            $data[$k]['month'] = date('Y-m', $v);;
            $data[$k]['firstday'] = strtotime($firstday);
            $data[$k]['lastday'] = strtotime($lastday);


        }

        return $data;


    }

    /***
     * @return mixed
     *
     * @create 2016-1-20
     *
     * @param post 数组
     *
     * @author lipengfu
     *
     *  统计中心数据
     */
    public function totalMoney()
    {

        $datas = $this->getthemonth();

        //遍历出 注册人数 ，投资总金额 ，投资人数
        foreach ($datas as $k => $v) {
            //每个注册月人数
            $where = 'addtime >=' . $v['firstday'] . ' and addtime <=' . $v['lastday'];
            $registers[] = M('user')->field('count(user_id) as users')->where($where)->select();
            //每个月投资总金额 及 投资人数
            $where1 = 'add_time >=' . $v['firstday'] . ' and add_time <=' . $v['lastday'];
            $sumInvestMoney[] = M('trade')->field('sum(total_money) as moneys,count(user_id) as userid')->where($where1)->select();

        }

        //将投资总金额的三位数组转二位数组
        foreach ($sumInvestMoney as $k => $v) {

            foreach ($v as $key => $value) {

                $investMoney[] = $value;
            }
        }
        // 将注册用户的ID遍历转换成一维数组
        foreach ($registers as $key => $value) {

            foreach ($value as $ko => $vo) {

                $regs[] = $vo['users'];


            }

        }
        // 将年-月 和 遍历 数组 成键值的关系 如 2016-1 =》2758
        foreach ($datas as $k => $v) {

            $regster[] = $regs[$k];
            $month[] = $v['month'];
            $sumTotalMoney[] = $investMoney[$k]['moneys'];
            $countInvestUid[] = $investMoney[$k]['userid'];

        }


        $data['month'] = $month;
        $data['regster'] = $regster;
        $data['sumTotalMoney'] = $sumTotalMoney;
        $data['countInvestUid'] = $countInvestUid;

        return $data;


    }

    /**
     * @param $datetime
     * @return array
     *
     * x轴坐标时间
     */
    public function regInvestTime($datetime)
    {

        $mon = date('Y', $datetime);
        $month = array();
        for ($i = 0; $i < 12; $i++) {

            array_push($month, $mon . '-' . (date('m') + $i));

        }

        return $month;


    }

    public function allInvestInfo($data)
    {
      
        //默认显示  默认类型为1 代表 充值人数
      if(empty($data)===true){
         $type=1;
        $month=$this->getthemonth();       
       foreach($month as $k=>$v){
         $months[]=$v['month'];
       $where = 'addtime >=' . $v['firstday'] . ' and addtime <=' . $v['lastday'];
       $czrs[]= M('account_log')->field('count(distinct user_id) as userid')->where($where)->select();

       }

        //将充值人数的三位数组转一位数组
            foreach ($czrs as $k => $v) {
                foreach ($v as $key => $value) {
                    $val[] = $value['userid'];
                }
            }
            $data['month'] = $months;
            $data['val'] = $val;
            $data['name'] = '充值人数';
            $data['xLabels']='month';
            return $data;

      }

      //搜索条件不为空 判断条件
      $time=$data['time'];
      $endtime=$data['endtime'];  
    
      if(empty($time) && empty($endtime)){

         $month=$this->getthemonth();             
         foreach($month as $k=>$v){
          $months[]=$v['month'];
          $where = 'addtime >=' . $v['firstday'] . ' and addtime <=' . $v['lastday'];   
          $where1 = 'add_time >=' . $v['firstday'] . ' and add_time <=' . $v['lastday'];     
            $czrs[]= M('account_log')->field('count(distinct user_id) as userid,sum(total) as totals')->where($where)->select();           
            $tixianNumbers[] = M('cash')->field('count(distinct user_id) as userid,sum(total) as tixianMoneys')->where($where)->select();           
            $sumInvestuid[] = M('trade')->field('count(user_id) as userid,sum(total_money) as moneys')->where($where1)->select();
            $registers[] = M('user')->field('count(user_id) as users')->where($where)->select();

         }
          
          foreach($czrs as $v=>$k){
            foreach($k as $key=>$value){
                $shrangmus[]=$value['userid'];//充值人数
                $shrangmusMoneys[]=$value['totals'];// 充值金额
            }
          }

           foreach($tixianNumbers as $v=>$k){
            foreach($k as $key=>$value){
                $cashval[]=$value['userid'];//提现人数
                $cashMoneys[]=$value['tixianMoneys'];//提现金额
            }
          }

           foreach($sumInvestuid as $v=>$k){
            foreach($k as $key=>$value){
                $investVal[]=$value['userid'];//投资人数
                $investMoneys[]=$value['moneys'];//投资金额
            }
          }


         foreach($registers as $v=>$k){
            foreach($k as $key=>$value){
                $registerVal[]=$value['users']; //注册人数；
               
            }
          }
        $type=$data['type'];
          if($type==1){
            $data['val'] = $shrangmus;
            $data['name'] = '充值人数';
            $data['month'] = $months;
            $data['xLabels']='month';
            return $data;

          }

          if($type==2){
            $data['val'] = $shrangmusMoneys;
            $data['name'] = '充值金额';
            $data['month'] = $months;
            $data['xLabels']='month';
            return $data;

          }



         if($type==3){
            $data['val'] = $cashval;
            $data['name'] = '提现人数';
            $data['month'] = $months;
            $data['xLabels']='month';
            return $data;

          }


          if($type==4){
            $data['val'] = $cashMoneys;
            $data['name'] = '提现金额';
            $data['month'] = $months;
            $data['xLabels']='month';
            return $data;

          }


          if($type==5){
            $data['val'] = $investVal;
            $data['name'] = '投资人数';
            $data['month'] = $months;
            $data['xLabels']='month';
            return $data;

          }


          if($type==6){
            $data['val'] = $investMoneys;
            $data['name'] = '投资金额';
            $data['month'] = $months;
            $data['xLabels']='month';
            return $data;

          }

          if($type==7){
            $data['val'] = $registerVal;
            $data['name'] = '注册人数';
            $data['month'] = $months;
            $data['xLabels']='month';
            return $data;

          }


      }
      
     if(!empty($time) && !empty($endtime)){
        $day=$this->diffBetweenTwoDays($time,$endtime);

       if($day>31){//日期大于31天
        $xLabels='month';
        $monthtime= $this->changTimws($time,$endtime);
        $month=$monthtime['month'];
        $months=$monthtime['months'];
        $time=strtotime($time);
        $endtime=strtotime($endtime);
    
       foreach($month as $k=>$v){
        $where='addtime >='.$v['firstday'].' and addtime <='.$v['lastday'];
        $where1='add_time >='.$v['firstday'].' and add_time <='.$v['lastday'];
            $czrs[]= M('account_log')->field('count(distinct user_id) as userid,sum(total) as totals')->where($where)->select();           
            $tixianNumbers[] = M('cash')->field('count(distinct user_id) as userid,sum(total) as tixianMoneys')->where($where)->select();           
            $sumInvestuid[] = M('trade')->field('count(user_id) as userid,sum(total_money) as moneys')->where($where1)->select();
            $registers[] = M('user')->field('count(user_id) as users')->where($where)->select();
       }   

          foreach($czrs as $v=>$k){
            foreach($k as $key=>$value){
                $shrangmus[]=$value['userid'];//充值人数
                $shrangmusMoneys[]=$value['totals'];// 充值金额
            }
          }

           foreach($tixianNumbers as $v=>$k){
            foreach($k as $key=>$value){
                $cashval[]=$value['userid'];//提现人数
                $cashMoneys[]=$value['tixianMoneys'];//提现金额
            }
          }

           foreach($sumInvestuid as $v=>$k){
            foreach($k as $key=>$value){
                $investVal[]=$value['userid'];//投资人数
                $investMoneys[]=$value['moneys'];//投资金额
            }
          }


         foreach($registers as $v=>$k){
            foreach($k as $key=>$value){
                $registerVal[]=$value['users']; //注册人数；
               
            }
          }
        $type=$data['type'];
          if($type==1){
            $data['val'] = $shrangmus;
            $data['name'] = '充值人数';
            $data['month'] = $months;
            $data['xLabels']=$xLabels;
            return $data;

          }

          if($type==2){
            $data['val'] = $shrangmusMoneys;
            $data['name'] = '充值金额';
            $data['month'] = $months;
            $data['xLabels']=$xLabels;
            return $data;

          }



         if($type==3){
            $data['val'] = $cashval;
            $data['name'] = '提现人数';
            $data['month'] = $months;
            $data['xLabels']=$xLabels;
            return $data;

          }


          if($type==4){
            $data['val'] = $cashMoneys;
            $data['name'] = '提现金额';
            $data['month'] = $months;
            $data['xLabels']=$xLabels;
            return $data;

          }


          if($type==5){
            $data['val'] = $investVal;
            $data['name'] = '投资人数';
            $data['month'] = $months;
            $data['xLabels']=$xLabels;
            return $data;

          }


          if($type==6){
            $data['val'] = $investMoneys;
            $data['name'] = '投资金额';
            $data['month'] = $months;
            $data['xLabels']=$xLabels;
            return $data;

          }

          if($type==7){
            $data['val'] = $registerVal;
            $data['name'] = '注册人数';
            $data['month'] = $months;
            $data['xLabels']=$xLabels;
            return $data;

          }
      
      }else{  //日期小于31天 
        $xLabels='day';
        $monthd=$this->dataDay($time,$endtime);

         $months=$monthd['months'];        
         $month=$monthd['month'];
           foreach($month as $k=>$v){
        $where='addtime >='.$v['firstday'].' and addtime <='.$v['lastday'];
        $where1='add_time >='.$v['firstday'].' and add_time <='.$v['lastday'];
            $czrs[]= M('account_log')->field('count(distinct user_id) as userid,sum(total) as totals')->where($where)->select();           
            $tixianNumbers[] = M('cash')->field('count(distinct user_id) as userid,sum(total) as tixianMoneys')->where($where)->select();           
            $sumInvestuid[] = M('trade')->field('count(user_id) as userid,sum(total_money) as moneys')->where($where1)->select();
            $registers[] = M('user')->field('count(user_id) as users')->where($where)->select();
       }   

          foreach($czrs as $v=>$k){
            foreach($k as $key=>$value){
                $shrangmus[]=$value['userid'];//充值人数
                $shrangmusMoneys[]=$value['totals'];// 充值金额
            }
          }

           foreach($tixianNumbers as $v=>$k){
            foreach($k as $key=>$value){
                $cashval[]=$value['userid'];//提现人数
                $cashMoneys[]=$value['tixianMoneys'];//提现金额
            }
          }

           foreach($sumInvestuid as $v=>$k){
            foreach($k as $key=>$value){
                $investVal[]=$value['userid'];//投资人数
                $investMoneys[]=$value['moneys'];//投资金额
            }
          }


         foreach($registers as $v=>$k){
            foreach($k as $key=>$value){
                $registerVal[]=$value['users']; //注册人数；
               
            }
          }
        $type=$data['type'];
          if($type==1){
            $data['val'] = $shrangmus;
            $data['name'] = '充值人数';
            $data['month'] = $months;
            $data['xLabels']=$xLabels;
            return $data;

          }

          if($type==2){
            $data['val'] = $shrangmusMoneys;
            $data['name'] = '充值金额';
            $data['month'] = $months;
            $data['xLabels']=$xLabels;
            return $data;

          }



         if($type==3){
            $data['val'] = $cashval;
            $data['name'] = '提现人数';
            $data['month'] = $months;
            $data['xLabels']=$xLabels;
            return $data;

          }


          if($type==4){
            $data['val'] = $cashMoneys;
            $data['name'] = '提现金额';
            $data['month'] = $months;
            $data['xLabels']=$xLabels;
            return $data;

          }


          if($type==5){
            $data['val'] = $investVal;
            $data['name'] = '投资人数';
            $data['month'] = $months;
            $data['xLabels']=$xLabels;
            return $data;

          }


          if($type==6){
            $data['val'] = $investMoneys;
            $data['name'] = '投资金额';
            $data['month'] = $months;
            $data['xLabels']=$xLabels;
            return $data;

          }

          if($type==7){
            $data['val'] = $registerVal;
            $data['name'] = '注册人数';
            $data['month'] = $months;
            $data['xLabels']=$xLabels;
            return $data;

          }


      }



     }


    }
     
     /**
      * 判断日期天数之间是否大于31天
      * @return 天数；
      * @param  开始时间  结束时间
      *
      *
     **/

    public function diffBetweenTwoDays($day1, $day2)
    {
        $second1 = strtotime($day1);
        $second2 = strtotime($day2);

        if ($second1 < $second2) {
            $tmp = $second2;
            $second2 = $second1;
            $second1 = $tmp;
        }
        return ($second1 - $second2) / 86400;
    }


     /**
      * 开始时间和结束时间整理
      * @return 日期 以数组形式
      * @param  开始时间  结束时间
      *
      *
     **/

    public function changTimws($starttime,$endtime)
    {
          
        $day = $this->diffBetweenTwoDays($starttime, $endtime);

        if ($day > 31) {
            $k = strtotime($starttime);
           // $e = strtotime($endtime);

            $n = ceil($day/31);

            if ($n >= 1) {
                for ($i = 0; $i < $n; $i++) {

                    $months[] = date('Y-'.(date('m',$k)+$i),$k);
                    // $months[] = strtotime(date('Y-'.(date('m',$k)+$i),$k));

                }
                $monthd['months']=$months; 
                $monthd['month']=$this->monthDay($months);
                 return $monthd; 
            }

        }


    }

  /**
  *  @return 返回指定月份的时间戳 开始时间， 和结束时间
  *
  *  @param  数组 日期格式 如2014-01
  *
  **/
   public function monthDay($data){
       
      for($i=0;$i<count($data);$i++){
           
            $firstday = date('Y-m-01', strtotime($data[$i]));
            $lastday = date('Y-m-d', strtotime("$firstday +1 month -1 day"));         
            $month[$i]['firstday'] = strtotime($firstday);
            $month[$i]['lastday'] = strtotime($lastday);
         

      }
      return $month;


   }
  /**
  * @return 二维数组 返回日期 ，时间戳(开始时间结束时间)
  *
  * @param  输入的开始时间，输入的结束时间
  *
  **/
  public function dataDay($time,$endtime){

        $k=strtotime($time);
       $day=$this->diffBetweenTwoDays($time,$endtime);
         
       for ($i = 0; $i <= $day; $i++) {

                    $months[] = date('Y-'.date('m',$k).'-'.(date('d',$k)+$i),$k);
                    
                }

           for($i=0;$i<count($months);$i++){
           
            $firstday = date('Y-m-d H:i:s', strtotime($months[$i]));

            $lastday = date('Y-m-d H:i:s', strtotime($firstday)+86399);         
           // dump($lastday);
            $month[$i]['firstday'] = strtotime($firstday);
            $month[$i]['lastday'] = strtotime($lastday);


             } 
       
         
                $monthd['months']=$months; 
                $monthd['month']=$month;
                 return $monthd; 

      }           
}