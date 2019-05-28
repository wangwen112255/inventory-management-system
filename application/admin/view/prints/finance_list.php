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
                        <h3>财务单</h3>
                    </td>
                </tr>
                <tr> 
                    <td colspan="2" align="right">
                        打印日期: {:date('Y-m-d')}
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table width="100%" border="1" cellspacing="0" cellpadding="2" align="center" bordercolor="#000000">
                            <tr>
                                <th height="30">#</th>
                                <th>分类</th>
                                <th>出入</th>
                                <th>支出</th>
                                <th>银行</th>
                                <th>经办人</th>
                                <th>创建人</th>
                                <th>经办日期</th>
                                <th>创建日期</th>
                                <th>备注</th>
                            </tr>
                            <?php
                            $i = 0;
                            $expenditure = 0;
                            $revenue = 0;
                            foreach ($lists as $key => $var) {
                                if ($var['type'])
                                    $revenue += $var['money'];
                                else
                                    $expenditure += $var['money'];
                                ?>
                                <tr>
                                    <td align="center" height="25"><?php echo ++$i ?></td>
                                    <td align="center">{$var.c_name}</td>
                                    <td align="center">
                                        <?php
                                        if ($var['type']) {
                                            echo '+' . $var['money'];
                                        }
                                        ?>
                                    </td>
                                    <td align="center">
                                    <?php
                                        if (!$var['type']) {
                                            echo '-' . $var['money'];
                                        }
                                        ?>
                                    </td>
                                    <td align="center">{$var.name}</td>
                                    <td align="center">{$var.nickname_attn}</td>
                                    <td align="center">{$var.nickname}</td>
                                    <td align="center">{:date('Y-m-d',$var.datetime)}</td>
                                    <td align="center">{$var.create_time}</td>
                                    <td >{$var.remark}</td>
                                </tr>
<?php } ?>
                            <tr>
                                <td colspan="11" align="right">&nbsp;&nbsp;合计支出：{$expenditure}, 合计收入：{$revenue}&nbsp;&nbsp;
                                </td>
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
