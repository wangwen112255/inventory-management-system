{extend name="base:base" /} {block name="body"} 
<div class="table-common">
    <div id="legend" class="">
        <a href="{:url('supplier')}" title="返回" class="btn btn-default"><i class="fa fa-angle-left"></i> 返回</a> 查看供应商
    </div>
</div>
<table class="table table-hover">
    <tr>
        <th style="width:130px;text-align:right">供应商名称</th>
        <td>
            {$var.company} </td>
    </tr>
    <tr>
        <th style="text-align:right">联系人</th>
        <td>
            {$var.name} </td>
    </tr>
    <tr>
        <th style="text-align:right">电话</th>
        <td>
            {$var.tel} </td>
    </tr>
    <tr>
        <th style="text-align:right">传真</th>
        <td>
            {$var.fax} </td>
    </tr>
    <tr>
        <th style="text-align:right">手机</th>
        <td>
            {$var.mobile} </td>
    </tr>
    <tr>
        <th style="text-align:right">网址</th>
        <td>
            {$var.site} </td>
    </tr>
    <tr>
        <th style="text-align:right">邮箱</th>
        <td>
            {$var.email} </td>
    </tr>
    <tr>
        <th style="text-align:right">地址</th>
        <td>
            {$var.address} </td>
    </tr>
    <tr>
        <th style="text-align:right">备注</th>
        <td>
            {$var.remark} </td>
    </tr>
    <tr>
        <th style="text-align:right">创建人</th>
        <td>
            {$var.nickname} </td>
    </tr>
    <tr>
        <th style="text-align:right">创建日期</th>
        <td>{$var.create_time}</td>
    </tr>
    <tr>
        <th style="text-align:right">最后更新</th>
        <td>
            {$var.nickname_replace}</td>
    </tr>
    <tr>
        <th style="text-align:right">更新日期</th>
        <td>
            {$var.update_time}</td>
    </tr>
</table>
{/block}