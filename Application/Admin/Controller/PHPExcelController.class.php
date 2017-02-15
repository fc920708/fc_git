<?php
/**
 * PHPEXCEL控制器
 * Created by PhpStorm.
 * User: fc
 * Date: 2016/1/6
 * Time: 10:46:21
 */
namespace Admin\Controller;
class PHPExcelController extends BaseController
{
    /**
     * 例子：导出
     * @author 丰超（fengchao@weizaojiao.cn）
     * @date 2016-1-6上午10:46:21
     * @version v2.0.0
     */
    public function PHPExcel($expTitle, $expCellName, $expTableData)
    {
        //导出数据
        $xlsTitle = iconv('utf-8', 'gb2312', $expTitle);//文件名称
        $fileName = $xlsTitle;
        $cellNum = count($expCellName);
        $dataNum = count($expTableData);
        $objPHPExcel = new  \Org\Util\PHPExcel();
        $cellName = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ');

        $objPHPExcel->getActiveSheet(0)->mergeCells('A1:' . $cellName[$cellNum - 1] . '1');//合并单元格
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $expTitle . '  ' . date('Y-m-d H:i:s'));
        for ($i = 0; $i < $cellNum; $i++) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i] . '2', $expCellName[$i][1]);
        }
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
        // Miscellaneous glyphs, UTF-8
        for ($i = 0; $i < $dataNum; $i++) {
            for ($j = 0; $j < $cellNum; $j++) {
                $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j] . ($i + 3), $expTableData[$i][$expCellName[$j][0]]);
            }
        }
        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="' . $xlsTitle . '.xls"');
        header("Content-Disposition:attachment;filename=$fileName.xls");//attachment新窗口打印inline本窗口打印
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

    /**
     * 例子：导出 csv
     * @author 丰超（fengchao@weizaojiao.cn）
     * @date 2016-1-6上午10:46:21
     * @version v2.0.0
     */
    public function PHPCsv($expTitle, $expCellName, $expTableData)
    {
        //导出数据
        $str = '';
        for ($k = 0; $k < count($expCellName); $k++) {
            $str .= iconv('utf-8', 'gb2312', $expCellName[$k]) . ","; //中文转码
        }
        $count = count($expCellName);
        for ($i = 0; $i < count($expTableData); $i++) {
            for ($s = 0; $s < count($expTableData[$i]); $s++) {
                if ($s % $count == 0) {
                    rtrim($str, ",");
                    $str .= "\n" . iconv('utf-8', 'gb2312', $expTableData[$i][$s]) . ",";
                } else {
                    $str .= iconv('utf-8', 'gb2312', $expTableData[$i][$s]) . ",";
                }
            }
        }

        $filename = $expTitle . '.csv'; //设置文件名
        header("Content-type:text/csv");
        header("Content-Disposition:attachment;filename=" . $filename);
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');
        echo $str;
    }

    /**
     * 例子：导出  用户列表
     * @author 丰超（fengchao@weizaojiao.cn）
     * @date 2016-1-6上午10:46:21
     * @version v2.0.0
     */
    public function PHPExcel_Users()
    {

        //文件名
        $expTitle = "用户列表";

        //表头数组  二维数组  每个子数组中  键值为0 推荐为字段名   键值为1推荐为字段注释 如下   
        //$expCellName 为固定变量名
        $expCellName[0][0] = 'user_id';    //此处推荐使用  字段名
        $expCellName[0][1] = '用户ID';    //此处推荐使用  字段备注
        $expCellName[1][0] = 'username';
        $expCellName[1][1] = '用户名称';
        $expCellName[2][0] = 'realname';
        $expCellName[2][1] = '真实姓名';
        $expCellName[3][0] = 'phone';
        $expCellName[3][1] = '手机号';
        $expCellName[4][0] = 'is_real';
        $expCellName[4][1] = '真实用户';
        $expCellName[5][0] = 'real_status';
        $expCellName[5][1] = '实名认证';
        $expCellName[6][0] = 'last_login_time';
        $expCellName[6][1] = '最后登录时间';

        //内容数组
        //$expTableData 为固定变量名
        //$expTableData 与 $expCellName的关联  例如 ： $expCellName[$i][0] =  $key ;  $expTableData[$i][$key] = "xxxxxx";
        $expTableData = M("User")->order("user_id desc")->select();//查询所有数据

        //如果有数据需要转换    执行以下步骤  例如 数据库中 时间戳 需要转换为 时间格式   各种判断类型  转换为中文
        foreach ($expTableData as $k => $v) {
            //用户是否为正式用户  0为虚拟  1为真实       转换覆盖
            if ((int)$expTableData[$k]['is_real'] == 0) {
                $expTableData[$k]['is_real'] = "虚拟";
            } else {
                $expTableData[$k]['is_real'] = "真实";
            }
            //用户是否为认证用户  0为未认证  1为认证  转换覆盖
            if ((int)$expTableData[$k]['real_status'] == 0) {
                $expTableData[$k]['real_status'] = "未认证";
            } else {
                $expTableData[$k]['real_status'] = "已认证";
            }
        }

        //导出数据
        $xlsTitle = iconv('utf-8', 'gb2312', $expTitle);//文件名称
        $fileName = $xlsTitle;
        $cellNum = count($expCellName);
        $dataNum = count($expTableData);
        $objPHPExcel = new  \Org\Util\PHPExcel();
        $cellName = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ');

        $objPHPExcel->getActiveSheet(0)->mergeCells('A1:' . $cellName[$cellNum - 1] . '1');//合并单元格
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $expTitle . '  ' . date('Y-m-d H:i:s'));
        for ($i = 0; $i < $cellNum; $i++) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i] . '2', $expCellName[$i][1]);
        }
        // Miscellaneous glyphs, UTF-8
        for ($i = 0; $i < $dataNum; $i++) {
            for ($j = 0; $j < $cellNum; $j++) {
                $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j] . ($i + 3), $expTableData[$i][$expCellName[$j][0]]);
            }
        }
        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="' . $xlsTitle . '.xls"');
        header("Content-Disposition:attachment;filename=$fileName.xls");//attachment新窗口打印inline本窗口打印
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

    /**
     * 过滤导出字段
     *
     * @author 八宝粥
     */
    public function filterExportField($arr, $list)
    {
        $head = array_keys($arr);
        $data = array();
        foreach ($list as $key => $v) {
            foreach ($arr as $j) {
                if (array_key_exists($j, $v)) {
                    $data[$key][] = $v[$j];
                } else {
                    $data[$key][] = $j;
                }

            }
        }
        return array('head' => $head, 'data' => $data);
    }


    /**
     * 导出EXCEL 根据指定键 导出数据
     *
     * @param $expTitle   标题 和 文件名
     * @param $expCellName   example:
     *                       array(
     *                            array('user_id','用户id'),
     *                            array('username','用户名'),
     *                       )
     * @param $expTableData  example:
     *                         array(
     *                              array('user_id'=>1,'username'=>'user1'),
     *                         )
     */
    public function exportExcelEx($expTitle, $expCellName, $expTableData)
    {
        //文件名

        //表头数组  二维数组  每个子数组中  键值为0 推荐为字段名   键值为1推荐为字段注释 如下
        //$expCellName 为固定变量名

        //内容数组
        //$expTableData 为固定变量名


        //导出数据
        $xlsTitle = iconv('utf-8', 'gb2312', $expTitle);//文件名称
        $fileName = $xlsTitle;
        $cellNum = count($expCellName);
        $dataNum = count($expTableData);
        $objPHPExcel = new  \Org\Util\PHPExcel();
        $cellName = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ');

        $objPHPExcel->getActiveSheet(0)->mergeCells('A1:' . $cellName[$cellNum - 1] . '1');//合并单元格
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $expTitle . '_' . date('Y-m-d H:i:s') . '.xls');
        for ($i = 0; $i < $cellNum; $i++) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i] . '2', $expCellName[$i][1]);
        }
        // Miscellaneous glyphs, UTF-8
        for ($i = 0; $i < $dataNum; $i++) {
            for ($j = 0; $j < $cellNum; $j++) {
                $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j] . ($i + 3), $expTableData[$i][$expCellName[$j][0]]);
            }
        }
        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="' . $xlsTitle . '.xls"');
        header("Content-Disposition:attachment;filename=$fileName.xls");//attachment新窗口打印inline本窗口打印
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }
}