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
                    <td colspan="2" height="21" align="center"><h1>产品入库单</h1></td>
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
                                <th height="30">ID</th>
                                <th>仓库</th>
                                <th>入库</th>
                                <th>货号</th>
                                <th>产品名称</th>
                                <th>单位</th>
                                <th>供应商</th>
                                <th>入库日期</th>
                            </tr>
                            <?php $number = 0; ?>
                            <?php foreach ($lists as $key => $var) {
                            ?>
                            <tr>
                                <td height="25">{:sprintf("%06d", $var.id)}</td>
                                <td align="center">{$var.warehouse}</td>
                                <td align="center">{$var.quantity}</td>
                                <td>{$var.code}</td>
                                <td>{$var.name}</td>
                                <td align="center">{$var.unit_name}</td>
                                <td>{$var.company}</td>
                                <td align="center">{$var.create_time}</td>
                            </tr>
                            <?php $number+=$var['quantity']; ?>
                            <?php } ?>
                            <tr>
                                <td colspan="2" align="right">合计</td>
                                <td colspan="8" align="left">&nbsp;&nbsp;{$number}</td>
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
