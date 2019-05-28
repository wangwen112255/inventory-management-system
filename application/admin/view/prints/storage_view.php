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
                    <td align="left"></td>
                    <td height="21" align="right">
                       <?php $nickname=$var['nickname']; ?>
                        {$var.company?'供应商: '.$var.company: ''}
                    </td>
                </tr>
                <tr> 
                    <td colspan="2" align="right">
                        入库日期: {$var.create_time}&nbsp;&nbsp;打印日期: {:date('Y-m-d')}
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
                             <?php 
                             $number = 0;
                             foreach ($sub_list as $key2 => $var2) {
                             $number+=$var2['quantity'];
                             ?>
                            <tr>
                                <td height="25">{:sprintf("%06d",$var2.id)}</td>
                                <td align="center">{$var2.warehouse}</td>
                                <td align="center">{$var2.quantity}</td>
                                <td>{$var2.code}</td>
                                <td>{$var2.name}</td>
                                <td align="center">{$var2.unit_name}</td>
                                <td>{$var2.company}</td>
                                <td align="center">{$var2.create_time}</td>
                            </tr>
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
                                    经办: {$nickname}&nbsp;&nbsp;&nbsp;&nbsp;打印: {$user_info.nickname}
                                </td>
                            </tr>
                        </table></td>
                </tr>
            </table>
        </div>
    </body>
</html>
