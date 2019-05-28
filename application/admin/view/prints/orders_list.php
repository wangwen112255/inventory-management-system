<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>TODO supply a title</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div>
            <table width="90%" border="0" cellpadding="0" cellspacing="2" align="center">
                <tr> 
                    <td colspan="2" height="21" align="center">
                        <h2> {:config('base.company')}</h2>
                        <h3>产品销售出库单</h3>
                    </td>
                </tr>
                <tr> 
                    <td colspan="2" align="right">
                        打印日期: {:date('Y-m-d H:i')}
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table width="100%" border="1" cellspacing="0" cellpadding="2" align="center" bordercolor="#000000">
                            <tr>
                                <th height="30">货号</th>
                                <th>产品名称</th>
                                <th>出库时间</th>
                                <th>发货日期</th>
                                <th>数量</th>
                                <th>单位</th>
                                <th>单价</th>
                                <th>金额</th>
                            </tr>
                            <?php
                            $quantity = 0;
                            $amount = 0;
                            $points = 0;
                            $sales = 0;
                            ?>
                            <?php
                            foreach ($lists as $key => $var) {
                                $var['product_data'] = unserialize($var['product_data']);
                                ?>
                                <?php
                                $quantity += $var['quantity'];
                                $amount += $var['amount'];
                                $sales += $var['product_data']['sales'];
                                ?>
                                <tr>
                                    <td height="25">{$var.product_data.code}</td>
                                    <td>{$var.product_data.name}</td>
                                    <td align="center">{$var.create_time}</td>
                                    <td align="center">{$var.ship_time}</td>
                                    <td align="center">{$var.quantity}</td>
                                    <td align="center">{$var.product_data.unit}</td>
                                    <td align="center">{$var.product_data.sales}</td>
                                    <td align="center">{$var.amount}</td>
                                </tr>
<?php } ?>
                            <tr>
                                <td colspan="7" align="right">合计</td>
                                <td align="center">{$amount}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="2" align="center">
                            <tr> 
                                <td height="21" align="left" width="50%">
                                    {:config('base.company')}
                                </td>
                                <td align="right" width="50%">
                                    打印: {$user_info.nickname}
                                </td>
                            </tr>
                        </table></td>
                </tr>
            </table>
        </div>
    </body>
</html>
