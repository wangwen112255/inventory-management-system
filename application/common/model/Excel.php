<?php

namespace app\common\model;

use app\common\model\Base;
use PHPExcel;
use PHPExcel_Cell_DataType;
use PHPExcel_IOFactory;
use PHPExcel_Style_Alignment;
use PHPExcel_Style_Fill;
use function array_out;

class Excel extends Base {

    /**
     * @title 导出库存列表
     * @date 19/07/31
     */
    public function product_stock_query_export($lists) {

        $lists = array_out($lists);
         
        $PHPExcel = new PHPExcel();
        // Set properties
        $PHPExcel->getProperties()->setCreator("Maarten Balliauw")
                ->setLastModifiedBy("Maarten Balliauw")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Test result file");
        // 获得当前活动sheet的操作对象
        $PHPSheet = $PHPExcel->getActiveSheet();
        // 给当前活动sheet设置名称
        $PHPSheet->setTitle('库存导出');
        // 第一行用来写标题
        $PHPSheet->setCellValue('A1', '#')
                ->setCellValue('B1', '仓库')
                ->setCellValue('C1', '商品')
                ->setCellValue('D1', '商品识别码')
                ->setCellValue('E1', '库存')
                ->setCellValue('F1', '产品分类')
                ->setCellValue('G1', '产品类型');
        $PHPExcel->getActiveSheet()->getStyle('A1:G1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $PHPExcel->getActiveSheet()->getStyle('A1:G1')->getFill()->getStartColor()->setARGB('FFFFFF00');

        $i = 2; //从第二行开始填充数据
        foreach ($lists as $key => $value) {

            $j = $i;

            $PHPSheet->setCellValue('A' . $i, sprintf('%06d', $value['inventory_id']));
            $PHPSheet->setCellValue('B' . $i, $value['warehouse']);
            $PHPSheet->setCellValue('C' . $i, $value['name']);
            $PHPSheet->setCellValue('D' . $i, $value['code']);
            $PHPSheet->setCellValue('E' . $i, $value['quantity']);
            $PHPSheet->setCellValue('F' . $i, $value['category']);
            $PHPSheet->setCellValue('G' . $i, $value['type']);

            $PHPExcel->getActiveSheet()->getStyle('A' . $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $PHPExcel->getActiveSheet()->getStyle('B' . $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $PHPExcel->getActiveSheet()->getStyle('C' . $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $PHPExcel->getActiveSheet()->getStyle('D' . $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $PHPExcel->getActiveSheet()->getStyle('E' . $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $PHPExcel->getActiveSheet()->getStyle('F' . $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $PHPExcel->getActiveSheet()->getStyle('G' . $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

            $i++;
        }

        $PHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(60);
        $PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $PHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $PHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
        $PHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
        // $PHPSheet->mergeCells('A1:B1');
        // dd($PHPExcel);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); //告诉浏览器输出07Excel文件
        //header('Content-Type:application/vnd.ms-excel');//告诉浏览器将要输出Excel03版本文件
        header('Content-Disposition: attachment;filename="Finance-' . date("YmdHis") . '.xlsx"'); //告诉浏览器输出浏览器名称
        header('Cache-Control: max-age=0'); //禁止缓存
        $PHPWriter = PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel2007'); //按照指定格式生成Excel文件，'Excel2007'表示生成2007版本的xlsx，'Excel5'表示生成2003版本Excel文件
        ob_clean();
        ob_start();
        $PHPWriter->save("php://output");
        ob_end_flush();
        exit();
    }

    /**
     * @title 导出出库列表
     * @param type $lists
     */
    public function product_sales_query_export($lists) {

        $PHPExcel = new PHPExcel(); //实例化PHPExcel类，类似于在桌面上新建一个Excel表格
        // Set properties
        $PHPExcel->getProperties()->setCreator("Maarten Balliauw")
                ->setLastModifiedBy("Maarten Balliauw")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Test result file");
        $PHPSheet = $PHPExcel->getActiveSheet(); //获得当前活动sheet的操作对象
        $PHPSheet->setTitle('出库导出'); //给当前活动sheet设置名称
        // 第一行用来写标题
        $PHPSheet->setCellValue('A1', '订单号')
                ->setCellValue('B1', '总额')
                ->setCellValue('C1', '收货信息')
                ->setCellValue('D1', '品名')
                ->setCellValue('E1', '数量')
                ->setCellValue('F1', '备注')
                ->setCellValue('G1', '出库类型')
                ->setCellValue('H1', '发货日期')
                ->setCellValue('I1', '快递公司')
                ->setCellValue('J1', '快递单号')
                ->setCellValue('K1', '客户名称');
        $PHPExcel->getActiveSheet()->getStyle('A1:K1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $PHPExcel->getActiveSheet()->getStyle('A1:K1')->getFill()->getStartColor()->setARGB('FFFFFF00');
        $i = 2; //从第二行开始填充数据
        foreach ($lists as $key => $value) {
            $j = $i;
            //->setCellValue('J' . $i, $value['express_num'])
            $PHPSheet->setCellValue('A' . $i, $value['order_number']);
            $PHPSheet->setCellValue('B' . $i, $value['amount']);
            $PHPSheet->setCellValue('C' . $i, $value['express_addr']);
            $PHPSheet->setCellValue('F' . $i, $value['remark']);
            $PHPSheet->setCellValue('G' . $i, $value['type']);
            $PHPSheet->setCellValue('H' . $i, $value['ship_time']);
            $PHPSheet->setCellValue('I' . $i, $value['express_name']);
            $PHPSheet->setCellValueExplicit('J' . $i, $value['express_num'], PHPExcel_Cell_DataType::TYPE_STRING); //防止单元格进行科学计数
            $PHPSheet->setCellValue('K' . $i, $value['nickname']);
            $lists_sub = model('product_sales_order_data')->get_order_data_lists($value['id']);
            foreach ($lists_sub as $key2 => $value2) {
                $product_data = unserialize($value2['product_data']);
                $PHPSheet->setCellValue('D' . $i, $product_data['name']);
                $PHPSheet->setCellValue('E' . $i, $value2['quantity']);
                //子行+1
                $i ++;
            }
            //如果存在子行，要合并父行
            $PHPExcel->getActiveSheet()->mergeCells('A' . $j . ':A' . ($i - 1));
            $PHPExcel->getActiveSheet()->mergeCells('B' . $j . ':B' . ($i - 1));
            $PHPExcel->getActiveSheet()->mergeCells('C' . $j . ':C' . ($i - 1));
            $PHPExcel->getActiveSheet()->mergeCells('F' . $j . ':F' . ($i - 1));
            $PHPExcel->getActiveSheet()->mergeCells('G' . $j . ':G' . ($i - 1));
            $PHPExcel->getActiveSheet()->mergeCells('H' . $j . ':H' . ($i - 1));
            $PHPExcel->getActiveSheet()->mergeCells('I' . $j . ':I' . ($i - 1));
            $PHPExcel->getActiveSheet()->mergeCells('J' . $j . ':J' . ($i - 1));
            $PHPExcel->getActiveSheet()->mergeCells('K' . $j . ':K' . ($i - 1));
            $PHPExcel->getActiveSheet()->getStyle('A' . $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $PHPExcel->getActiveSheet()->getStyle('B' . $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $PHPExcel->getActiveSheet()->getStyle('C' . $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $PHPExcel->getActiveSheet()->getStyle('F' . $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $PHPExcel->getActiveSheet()->getStyle('G' . $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $PHPExcel->getActiveSheet()->getStyle('H' . $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $PHPExcel->getActiveSheet()->getStyle('I' . $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $PHPExcel->getActiveSheet()->getStyle('J' . $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $PHPExcel->getActiveSheet()->getStyle('K' . $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
//            $PHPExcel->getActiveSheet()->getStyle('A' . $j)->applyFromArray(
//                    array(
//                        'alignment' => array(
//                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
//                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
//                        )
//                    )
//            );
            // $PHPExcel->getActiveSheet()->getStyle('A'.($i-1))->getAlignment()->setHorizontal()->setVertical();
        }
        $PHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
        $PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(75);
        $PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
        $PHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $PHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(30);
        $PHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
        //   $PHPSheet->mergeCells('A1:B1');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); //告诉浏览器输出07Excel文件
        //header('Content-Type:application/vnd.ms-excel');//告诉浏览器将要输出Excel03版本文件
        header('Content-Disposition: attachment;filename="WarehouseOut-' . date("YmdHis") . '.xlsx"'); //告诉浏览器输出浏览器名称
        header('Cache-Control: max-age=0'); //禁止缓存
        $PHPWriter = PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel2007'); //按照指定格式生成Excel文件，'Excel2007'表示生成2007版本的xlsx，'Excel5'表示生成2003版本Excel文件

        ob_clean();
        ob_start();
        $PHPWriter->save("php://output");
        ob_end_flush();
        exit();
    }

    /**
     * @title 导出财务列表
     * @param type $lists
     */
    public function finance_export($lists) {
        //  dd(array_out($lists));
        $lists = array_out($lists);
        //dd(array_out($lists));
        $PHPExcel = new PHPExcel(); //实例化PHPExcel类，类似于在桌面上新建一个Excel表格
        // Set properties
        $PHPExcel->getProperties()->setCreator("Maarten Balliauw")
                ->setLastModifiedBy("Maarten Balliauw")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Test result file");
        $PHPSheet = $PHPExcel->getActiveSheet(); //获得当前活动sheet的操作对象
        $PHPSheet->setTitle('财务导出'); //给当前活动sheet设置名称
        // 第一行用来写标题
        $PHPSheet->setCellValue('A1', '类别')
                ->setCellValue('B1', '出入')
                ->setCellValue('C1', '支出')
                ->setCellValue('D1', '银行')
                ->setCellValue('E1', '经办人')
                ->setCellValue('F1', '经办时间')
                ->setCellValue('G1', '备注');
        $PHPExcel->getActiveSheet()->getStyle('A1:G1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $PHPExcel->getActiveSheet()->getStyle('A1:G1')->getFill()->getStartColor()->setARGB('FFFFFF00');
        $i = 2; //从第二行开始填充数据
        foreach ($lists as $key => $value) {
            $j = $i;
            $PHPSheet->setCellValue('A' . $i, $value['c_name']);
            if ($value['type'])
                $PHPSheet->setCellValue('B' . $i, $value['money']);
            else
                $PHPSheet->setCellValue('C' . $i, $value['money']);
            $PHPSheet->setCellValue('D' . $i, $value['name']);
            $PHPSheet->setCellValue('E' . $i, $value['nickname_attn']);
            $PHPSheet->setCellValue('F' . $i, date('Y-m-d H:i', $value['datetime']));
            $PHPSheet->setCellValue('G' . $i, $value['remark']);
            $i++;
            $PHPExcel->getActiveSheet()->getStyle('A' . $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $PHPExcel->getActiveSheet()->getStyle('B' . $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $PHPExcel->getActiveSheet()->getStyle('C' . $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $PHPExcel->getActiveSheet()->getStyle('D' . $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $PHPExcel->getActiveSheet()->getStyle('E' . $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $PHPExcel->getActiveSheet()->getStyle('F' . $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $PHPExcel->getActiveSheet()->getStyle('G' . $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        }
        $PHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
        $PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $PHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $PHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
        $PHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(80);
        // $PHPSheet->mergeCells('A1:B1');
        // dd($PHPExcel);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); //告诉浏览器输出07Excel文件
        //header('Content-Type:application/vnd.ms-excel');//告诉浏览器将要输出Excel03版本文件
        header('Content-Disposition: attachment;filename="Finance-' . date("YmdHis") . '.xlsx"'); //告诉浏览器输出浏览器名称
        header('Cache-Control: max-age=0'); //禁止缓存
        $PHPWriter = PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel2007'); //按照指定格式生成Excel文件，'Excel2007'表示生成2007版本的xlsx，'Excel5'表示生成2003版本Excel文件
        ob_clean();
        ob_start();
        $PHPWriter->save("php://output");
        ob_end_flush();
        exit();
    }

}
