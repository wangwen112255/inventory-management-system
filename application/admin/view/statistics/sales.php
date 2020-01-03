{extend name="base:base" /} {block name="body"} 
<div class="container-fluid">
    <form id="forminventorysupplier" class="form-inline" action="<?php echo url('statistics/sales'); ?>" accept-charset="utf-8" method="get">
        <table class="table table-hover">
            <tbody>
                <tr>
                    <td>
                        <input type="text" placeholder="识别码/产品名称" name="keyword" value="{$Think.get.keyword}" class="form-control" id="autoproduct">
                        <input type="text" placeholder="会员姓名" name="nickname" value="{$Think.request.nickname}" class="form-control" id="automember">
                        <input size="16" type="text" class="form_datetime form-control" name="timea" value="{$Think.request.timea}" placeholder="创建开始日期">
                        <i class="icon-resize-horizontal"></i>
                        <input size="16" type="text" class="form_datetime form-control" name="timeb" value="{$Think.request.timeb}" placeholder="创建结束日期">
                        <button type="submit" class="btn btn-primary" title="查询银行"><i class="iconfont icon-sousuo"></i> 搜索</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
    <p>
        <small>
            <i class="iconfont icon-wushuju"></i> 合计<strong>{:array_sum($list.quantity)}</strong>个销售产品，
            合计销售额：<strong>{:array_sum($list.sales)}</strong> 元
        </small>
    </p>
    <div id="main" style="height:450px;border:0px solid #ccc;padding:10px;"></div>
</div>
{/block}
{block name="foot_js"} 
<!-- 引入 ECharts 文件 -->
<script src="__PUBLIC__/libs/echarts/echarts.common.min.js"></script>
<script type="text/javascript">
    // 基于准备好的dom，初始化echarts实例
    var myChart = echarts.init(document.getElementById('main'));
    // 指定图表的配置项和数据
    var option = {
        title: {
            text: "销售统计观图",
            subtext: '{$Think.request.timea}至{$Think.request.timeb}'
        },
        tooltip: {},
        legend: {
            data: ['销量']
        },
        xAxis: {
            type: 'category',
            splitLine: {show: false},
            data: [<?php echo implode(',', $list['date']); ?>]
        },
        yAxis: {},
        series: [{
                name: '销量',
                type: 'bar',
                data: [<?php echo implode(',', $list['sales']); ?>]
            }]
    };
    myChart.setOption(option);
</script>
{/block}
