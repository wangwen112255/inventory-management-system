<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>TODO supply a title</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div><br><br>
            <table width="90%" border="0" cellpadding="0" cellspacing="5" align="center" >
                <tr>
                    <td height="21" align="center"><h2> {:config('base.company')}</h2>
                        <h3>产品出库单</h3></td>
                </tr>
                <tr>
                    <td height="21" align="left"> 客户: <span style="text-decoration:underline;"> {$info.nickname? $info.nickname : '无' } </span> &nbsp;&nbsp;物流：<span style="text-decoration:underline;"> {$info.express_name} </span> &nbsp;&nbsp;单号：<span style="text-decoration:underline;"> {$info.express_num} </span></td>
                </tr>
                <tr>
                    <td align="left">收货地址：<span style="text-decoration:underline;">{$info.express_addr}</span></td>
                </tr>
                <tr>
                    <td><table width="100%" border="1" cellspacing="0" cellpadding="2" align="center" bordercolor="#000000">
                            <tr>
                                <th height="30">货号</th>
                                <th>产品名称</th>
                                <th>规格</th>
                                <th>数量</th>
                                <th>单位</th>
                    <!--            <th>金额</th>-->
                                <?php
                                if (strpos($info['nickname'], '宏顺物流') != FALSE) {
                                    echo '<th>金额</th>';
                                }
                                ?>
                            </tr>
                            <?php
                            $quantity = 0;
                            $amount = 0;
                            $sales = 0;
                            ?>
                            <?php
                            foreach ($orders as $key => $var) {
                                $var['product_data'] = unserialize($var['product_data']);
                                
                                $units = db('product_unit')->column('id,name');
                                
                                ?>
                                <?php
                                $quantity += $var['quantity'];
                                $amount += $var['amount'];
                                $sales += $var['product_data']['sales'];
                                ?>
                                <tr>
                                    <td height="25" align="center">{$var.product_data.code}</td>
                                    <td align="center">{$var.product_data.name}</td>
                                    <td align="center">{$var.product_data.format}</td>
                                    <td align="center">{$var.quantity}</td>
                                    <td align="center">
                                            <?php 
                                            echo isset($units[$var['product_data']['unit']]) ? $units[$var['product_data']['unit']]: '';
                                            ?>
                                         </td>
    <?php
    if (strpos($info['nickname'], '宏顺物流') != FALSE) {
        echo ' <td align="center"> ' . number_format($var['amount'], 2) . ' </td>';
    }
    ?>
    <!--            <td align="center"> <?php echo number_format($var['amount'], 2); ?> </td>-->
                                </tr>
                            <?php } ?>
                            <tr>
                                <td align="center">合计</td>
                                <td align="center">&nbsp;</td>
                                <td align="center"></td>
                                <td align="center">{$quantity}</td>
                                <td align="center">&nbsp;</td>
                                <?php
                                if (strpos($info['nickname'], '宏顺物流') != FALSE) {
                                    echo ' <td align="center"> ' . number_format($amount, 2) . ' </td>';
                                }
                                ?>
<!--            <td align="center"> <?php echo number_format($amount, 2); ?> </td>-->
                            </tr>
                        </table></td>
                </tr>
                <tr>
                    <td><table width="100%" border="0" cellpadding="0" cellspacing="2" align="center">
                            <tr>
                                <td height="21" align="left" width="50%">出库日期: {$info.ship_time}</td>
                                <td align="right" width="50%"> 经办: {$info.staff_nickname}  &nbsp;&nbsp;打印: {$user_info.nickname}</td>
                            </tr>
                            <tr>
                                <td height="21" colspan="2" align="left">备注：{$info.remark}
                                    <!--打印日期: {:date('Y-m-d H:i:s')}--></td>
                            </tr>
                        </table></td>
                </tr>
            </table>
        </div>
    </body>
</html>
