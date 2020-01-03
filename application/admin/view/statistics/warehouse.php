{view 'public/head'}
</head>
<body>
    <div class="container-fluid">
        <form id="forminventorysupplier" class="form-inline" action="{site 'statistics/warehouse'}" accept-charset="utf-8" method="get">
            <input size="16" type="text" class="form_datetime form-control" name="timea" value="{$Think.request.timea}" placeholder="创建开始日期">
            <i class="icon-resize-horizontal"></i>
            <input size="16" type="text" class="form_datetime form-control" name="timeb" value="{$Think.request.timeb}" placeholder="创建结束日期">

            <select name="warehouse" class="form-control">
                <option value="">所有仓库</option>
                {volist name="warehouse" id="var"}
                <option value="{$var.w_id}"{eq name="Think.request.warehouse" value="$var.w_id"} selected{/eq}>{$var.w_name}</option>
                {/volist}
            </select>
            <button type="submit" class="btn btn-primary" title="查询银行"><i class="iconfont icon-sousuo"></i> 搜索</button>
        </form>
        <p>
            <small><i class="iconfont icon-wushuju"></i> 查询到仓库合计<strong>{$quantity}</strong>个产品</small>
        </p>
        <div id="main" style="height:450px;border:0px solid #ccc;padding:10px;"></div>

    </div>
    {view 'public/js'}
    {js 'assets/echarts/esl/esl.js'}
    {js 'assets/echarts/echarts-plain.js'}
    <script type="text/javascript">
                var option = {
                title: {
                text: '仓库统计观图',
                        subtext: '{$Think.request.timea}至{$Think.request.timeb}'
                },
                        tooltip: {
                        trigger: 'axis'
                        },
                        legend: {
                        data: ['销售', '报废', '退回', '退货']
                        },
                        toolbox: {
                        show: true,
                                feature: {
                                mark: {show: true},
                                        dataView: {show: true, readOnly: false},
                                        magicType: {show: true, type: ['line', 'bar', 'stack', 'tiled']},
                                        restore: {show: true},
                                        saveAsImage: {show: true}
                                }
                        },
                        calculable: true,
                        xAxis: [
                        {
                        type: 'category',
                                boundaryGap: false, splitLine : {show : false},
                                data: [{implode(',', $purchase.date)}]
                        }
                        ],
                        yAxis: [
                        {
                        type: 'value'
                        }
                        ],
                        series: [
                        {
                        name: '销售',
                                type: 'line',
                                smooth: true,
                                data: [{implode(',', $sales.quantity)}]
                        },
                        {
                        name: '报废',
                                type: 'line',
                                smooth: true,
                                data: [{implode(',', $scrapped.obsolescence)}]
                        },
                        {
                        name: '退回',
                                type: 'line',
                                smooth: true,
                                data: [{implode(',', $company_returns.quantity)}]
                        },
                        {
                        name: '退货',
                                type: 'line',
                                smooth: true,
                                data: [{implode(',', $sales_returns.return)}]
                        }
                        ]
                };
                echarts.init(document.getElementById('main')).setOption(option);
    </script>
</body>
</html>