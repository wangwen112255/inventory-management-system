{view 'public/head'}
{if $chart == '1'}
<style>
    .x-chart-labels{display: none;}
</style>
{/if}
</head>
<body>
    <div class="container-fluid">

        <form class="form-inline" id="financequery" action="{site 'statistics/accounts/'.$py}" accept-charset="utf-8" method="get">

                            
                            
                            <input size="16" type="text" class="form-control" onClick="WdatePicker({dateFmt: 'yyyy-MM-dd HH:mm'})" style="width:110px" name="timea" value="{$Think.request.timea}" placeholder="创建开始日期">
                            <i class="icon-resize-horizontal"></i>
                            <input size="16" type="text" class="form-control" onClick="WdatePicker({dateFmt: 'yyyy-MM-dd HH:mm'})" style="width:110px" name="timeb" value="{$Think.request.timeb}" placeholder="创建结束日期">


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
                                <button type="button" onclick="$('#chartinput').val(0)" class="btn{$Think.request.chart=='0'||$Think.request.chart==''?' active':''}">统计表</button>
                                <button type="button" onclick="$('#chartinput').val(1)" class="btn{$Think.request.chart=='1'||$Think.request.chart==''?' active':''}">区域图</button>
                                <button type="button" onclick="$('#chartinput').val(2)" class="btn{$Think.request.chart=='2'?' active':''}">分布图</button>
                            </div>
                            <input type="hidden" id="chartinput" name="chart" value="{$chart}" />
                            <button type="submit" class="btn btn-primary" title="查询银行"><i class="iconfont icon-sousuo"></i> 搜索</button>
                            
        </form>
        <p>
            <small><i class="iconfont icon-wushuju"></i> 查询结果每60秒更新一次</small>
        </p>
        <p id='canvas'></p>



        {view 'public/js'}

        <script type="text/javascript">
            {if $chart == '0'}
            
    {else}
                    BUI.use('bui/chart', function (Chart) {
                    {if $chart == '2'}
                    var chart = new Chart.Chart({
                    render: '#canvas',
                            width: 1000,
                            height: 500,
                            title: {
                            text: '收支图'
                            },
                            legend: null, //不显示图例
                            seriesOptions: {//设置多个序列共同的属性
                            pieCfg: {
                            allowPointSelect: true,
                                    labels: {
                                    distance: 40,
                                            label: {
                                            //文本信息可以在此配置
                                            },
                                            renderer: function (value, item) { //格式化文本
                                            return value + ' ' + (item.point.percent * 100).toFixed(2) + '%';
                                            }
                                    }
                            }
                            },
                            tooltip: {
                            pointRenderer: function (point) {
                            return (point.percent * 100).toFixed(2) + '%';
                            }
                            },
                            series: [{
                            type: 'pie',
                                    name: '总账务的',
                                    data: [
                                            ['支出{$expenditure}', {$expenditure}],
                                            ['收入{$revenue}', {$revenue}]
                                    ]
                            }]
                    });
                    {else}
                   var chart = new Chart.Chart({
        render : '#canvas',
       
        height : 500,
        plotCfg : {
          margin : [50,50,80] //画板的边距
        },
        title : {
          text : '区域图'
 
        },
        xAxis : {
          categories : [{$day}]
        },
        
         seriesOptions : { //设置多个序列共同的属性
              areaCfg : { //如果数据序列未指定类型，则默认为指定了xxCfg的类型，否则都默认是line
                markers : {
                  single : true
                }
   
              }
            },
        tooltip : {
          valueSuffix : '元',
          shared : true, //是否多个数据序列共同显示信息
          crosshairs : true //是否出现基准线
        },
        series : [{
              name: '支出',
              data: [{implode(',', $list.expenditure)}]
          }, {
              name: '收入',
              data: [{implode(',', $list.revenue)}]
          }]
      });
 
                    {/if}
                            chart.render();
                    });{/if}
        </script>
</body>
</html>