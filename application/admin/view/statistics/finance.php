{view 'public/head'}
{if $chart == '1'}
<style>
    .x-chart-labels{display: none;}
</style>
{/if}
</head>
<body>
    <div class="container-fluid">

        <form class="form-inline" id="financequery" action="{site 'statistics/finance/'.$py}" accept-charset="utf-8" method="get">



            <input size="16" type="text" class="form_datetime form-control" name="timea" value="{$Think.request.timea}" placeholder="创建开始日期">
            <i class="icon-resize-horizontal"></i>
            <input size="16" type="text" class="form_datetime form-control" name="timeb" value="{$Think.request.timeb}" placeholder="创建结束日期">


            <select class="form-control" name="b_id">
                <option value="">银行</option>
                {loop $this->m_finance_bank->finds() as $var}
                <option value="{$var.id}"{$var.id===$Think.request.b_id?' selected':''}>{$var.bank}</option>
                {/volist}
            </select>
            <select class="form-control" name="status">
                <option value="1"{$Think.request.status=='1'?' selected':''}>正常</option>
                <option value="0"{$Think.request.status=='0'?' selected':''}>撤销</option>

            </select>

            <select name="attn" class="form-control">
                <option value="">经办人</option>
                {volist name="staffs" id="staff"}
                <option value="{$staff.uid}"{eq name="Think.request.attn" value="$staff.uid"} selected{/eq}>{$staff.nickname}</option>
                {/volist}
            </select>
            <select name="uid" class="form-control">
                <option value="">创建人</option>
                {volist name="staffs" id="staff"}
                <option value="{$staff.uid}"{eq name="Think.request.uid" value="$staff.uid"} selected{/eq}>{$staff.nickname}</option>
                {/volist}
            </select>


            <div class="btn-group" data-toggle="buttons-radio">
                <button type="button" onclick="$('#chartinput').val(0);$('form').submit()" class="btn{empty($chart)?' active':''}"><i class="icon-bar-chart"></i> 宏观图</button>
                <button type="button" onclick="$('#chartinput').val(1);$('form').submit()" class="btn{!empty($chart)?' active':''}"><i class="icon-dashboard"></i> 分布图</button>
            </div>

            <input type="hidden" id="chartinput" name="chart" value="{$chart}" />
            <button type="submit" class="btn btn-primary" title="查询"><i class="iconfont icon-sousuo"></i> 查询</button>

        </form>
        <p>
            <small><i class="iconfont icon-wushuju"></i> 收入:<strong>{$revenue?:0}</strong> 支出:<strong>{$expenditure?:0}</strong></small>
        </p>


        <div id="main" style="height:450px;border:0px solid #ccc;padding:10px;"></div>




        {view 'public/js'}
        {js 'assets/echarts/esl/esl.js'}
    {js 'assets/echarts/echarts-plain.js'}
        <script type="text/javascript">
            {if empty($chart)}
                    var option = {
                    title: {
                    text: '账务统计宏观图',
                            subtext: '{$Think.request.timea}至{$Think.request.timeb} 收入:{$revenue?:0} 支出:{$expenditure?:0}'
                    },
                            tooltip: {
                            trigger: 'axis'
                            },
                            legend: {
                            data: ['收入', '支出']
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
                                    boundaryGap: false,
                                    splitLine : {show : false},
                                    data: [{implode(',', $list.date)}]
                            }
                            ],
                            yAxis: [
                            {
                            type: 'value'
                            }
                            ],
                            series: [
                            {
                            name: '收入',
                                    type: 'line',
                                    smooth: true,
                                    itemStyle: {normal: {areaStyle: {type: 'default'}}},
                                    data: [{implode(',', $list.revenue)}],
            markLine : {
                data : [
                    {type : 'average', name: '平均值'}
                ]
            }

                            },
                            {
                            name: '支出',
                                    type: 'line',
                                    smooth: true,
                                    itemStyle: {normal: {areaStyle: {type: 'default'}}},
                                    data: [{implode(',', $list.expenditure)}],
            markLine : {
                data : [
                    {type : 'average', name : '平均值'}
                ]
            }

                            }
                            ]
                    };
                    {else}
                    var option = {
                    title : {
                    text: '收支分部图',
                            subtext: '{$Think.request.timea}至{$Think.request.timeb} 收入:{$revenue?:0} 支出:{$expenditure?:0}',
                            x:'center'
                    },
                            tooltip : {
                            trigger: 'item',
                                    formatter: "{a} <br/>{b} : {c} ({d}%)"
                            },
                            legend: {
                            orient : 'vertical',
                                    x : 'left',
                                    data:['收入', '支出']
                            },
                            toolbox: {
                            show : true,
                                    feature : {
                                    mark : {show: true},
                                            dataView : {show: true, readOnly: false},
                                            restore : {show: true},
                                            saveAsImage : {show: true}
                                    }
                            },
                            calculable : true,
                            series : [
                            {
                            name:'支出分部图',
                                    type:'pie',
                                    radius : '60%',
                                    center: ['50%', '60%'],
                                    data:[
                                    {value:{$revenue?:0}, name:'收入'},
                                    {value:{$expenditure?:0}, name:'支出'}
                                    ]
                            }
                            ]
                    };
                    {/if}
                    
                    
                    echarts.init(document.getElementById('main')).setOption(option);

        </script>

</body>
</html>