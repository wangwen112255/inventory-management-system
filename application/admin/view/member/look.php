{extend name="base:base" /} {block name="body"} 
        <form class="form-horizontal" method="post">
                查看会员 <a href="" class="btn btn-default" title="查看"><i class="fa fa-angle-left"></i> 返回</a>
           <hr />
            <table class="table table-hover">
                <tr>
                    <th style="width:130px;text-align:right">会员组：</th>
                    <td>
                        {$look.category}
                    </td>
                    <th style="width:130px;text-align:right">会员姓名：</th>
                    <td>{$look.nickname}</td>
                    <th style="text-align:right">会员性别：</th>
                    <td>{$look.sex}</td>
                    <th style="text-align:right">会员卡号：</th>
                    <td>{$look.card}</td>
                </tr>
                <tr>
                    <th style="text-align:right">联系电话：</th>
                    <td>{$look.tel}</td>
                    <th style="text-align:right">QQ：</th>
                    <td>{$look.qq}</td>
                    <th style="text-align:right">Email：</th>
                    <td>{$look.email}</td>
                    <th style="text-align:right">身份证号：</th>
                    <td>{$look.id_card}</td>
                </tr>
                <tr>
                    <th style="text-align:right">会员生日：</th>
                    <td>{$look.birthday!=='0000-00-00'?$look.birthday:''}</td>
                    <th style="text-align:right">会员积分：</th>
                    <td>{$look.points} </td>
                    <th style="text-align:right">创建人：</th>
                    <td>{$look.s_nickname}</td>
                    <th style="text-align:right">创建日期：</th>
                    <td>{$look.create_time}</td>
                </tr>
                <tr>
                    <th style="text-align:right">家庭住址：</th>
                    <td colspan="3">{$look.address}</td>
                    <th style="text-align:right">更新人：</th>
                    <td>{$look.u_nickname}</td>
                    <th style="text-align:right">更新时间：</th>
                    <td>{$look.update_time}</td>
                </tr>
                <tr>
                  <th style="text-align:right">备注：</th>
                  <td colspan="7">{$look.remark}</td>
                </tr>
            </table>
        </form>
        <div id="legend" class="">
            积分日志 <a href="javascript:history.back(-1);" title="返回" class="btn btn-default"><i class="fa fa-angle-left"></i> 返回</a>
        </div>
        <p>
            <small><i class="fa fa-info-sign"></i> 查询到了<strong>{$count}</strong>个积分记录</small>
        </p>
<table class="table table-hover table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>标题</th>
            <th>积分</th>
            <th>创建时间</th>
            <th>类型</th>
            <th>操作人</th>
            <th style="width:70px;text-align:center">订单</th>
        </tr>
    </thead>
    <tbody>
        {volist name="lists" id="var"}
        <tr>
            <td>{:sprintf("%06d",$var.id)}</td>
            <td>{$var.title}</td>
            <td>{$var.value}</td>
            <td>{$var.create_time}</td>
            <td>
                {eq name="var.type" value="1"}
<span class="badge badge-success">收入</span>
{else/}
<span class="badge badge-important">支出</span>
{/eq}
            </td>
            <td>{$var.nickname}</td>
            <td style="text-align:center"><a href="<?php echo url('inventory/sales_look', ['id'=>$var['m_id']]);?>" title="查看记录">
                    <i class="fa fa-search"></i> 查看</a></td>
        </tr>
        {/volist}
    </tbody>
</table>
        {$pages}
        {/block}
        