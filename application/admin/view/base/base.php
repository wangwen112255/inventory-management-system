<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-urlA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
        <title></title>
        <!-- Set render engine for 360 browser -->
        <meta name="renderer" content="webkit">
        <!-- Bootstrap -->
        <link href="__PUBLIC__/libs/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
        <link href="__PUBLIC__/libs/todc-bootstrap/todc-bootstrap.css" rel="stylesheet">
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="__PUBLIC__/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="__PUBLIC__/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <link href="__PUBLIC__/libs/font-awesome/4.2.0/css/font-awesome.min.css"  rel="stylesheet" type="text/css">     
        <link rel="stylesheet" href="__STATIC__/admin/css/style.css" />
    </head>
    <body>
        <div class="container-fluid body">
            <div class="row">    
                <div class="col-sm-12">
                    {block name="body"} 
                    {/block}
                </div>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <div class="modal fade  bs-example-modal-lg" tabindex="-1" role="dialog" id="modal_big">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="__PUBLIC__/libs/jquery/1.9.1/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="__PUBLIC__/libs/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    </body>
</html>
<!--自定义的一些JS函数--> 
<script src="__STATIC__/admin/js/common.js"></script>
<script src="__STATIC__/admin/js/init.js"></script>
<!--加载时间框--> 
<!-- this should go after your </body> -->
<link rel="stylesheet" type="text/css" href="__PUBLIC__/libs/datetimepicker/jquery.datetimepicker.css" />
<script src="__PUBLIC__/libs/datetimepicker/jquery.datetimepicker.js"></script> 
<script>
    $(function () {
        $('.datetime_search').datetimepicker(
                {lang: 'zh', format: 'Y-m-d', timepicker: false, closeOnDateSelect: true});
    });
</script> 
<!--加载时间框END-->
<!--表单自动保存-->
<script src="__PUBLIC__/libs/sisyphus/sisyphus.min.js"></script>
<!--自动下拉提示-->
<link rel="stylesheet" href="__PUBLIC__/libs/autocomplete/autocomplete.css" />
<script src="__PUBLIC__/libs/autocomplete/jquery.autocomplete.min.js"></script>
<!--联动下拉http://www.jq22.com/jquery-info3238-->
<script src="__PUBLIC__/libs/jquery.cxselect/jquery.cxselect.min.js"></script>
<!-- 提示组件-->
<link href="__PUBLIC__/libs/toastr/toastr.min.css" rel="stylesheet">
<script type="text/javascript" src="__PUBLIC__/libs/toastr/toastr.min.js"></script>
<script>
    toastr.options = {
        "closeButton": true,
        "positionClass": "toast-bottom-center"
    }
</script>
<script>
    $(function () {
        $("#modal").on("hidden.bs.modal", function () {
            $(this).removeData("bs.modal");
        });
        $("#modal_big").on("hidden.bs.modal", function () {
            $(this).removeData("bs.modal");
        });
    });
</script>
<!--以下代码专门用于实现进销系统打印-->
<object  id="LODOP_OB" classid="clsid:2105C259-1E0C-4534-8141-A753534CB4CA" width=0 height=0> 
    <embed id="LODOP_EM" type="application/x-print-lodop" width=0 height=0></embed>
</object>
<script type="text/javascript" src="__PUBLIC__/libs/lodop/LodopFuncs.js"></script>
<script type="text/javascript">
    function post_sisyphus() {
//        $("form").sisyphus({
//            customKeySuffix: "{:md5($Request.path)}",
//            onRestore: function () {
//                toastr.info('已恢复历史数据');
//            }
//        });
    }
    var LODOP; //声明为全局变量      
    function PrintOneURL(url, title) {
        LODOP = getLodop();
        LODOP.PRINT_INIT(title);
        LODOP.ADD_PRINT_URL(30, 20, 746, "95%", url);
        LODOP.SET_PRINT_STYLEA(0, "HOrient", 3);
        LODOP.SET_PRINT_STYLEA(0, "VOrient", 3);
        //LODOP.SET_SHOW_MODE("MESSAGE_GETING_URL",""); //该语句隐藏进度条或修改提示信息
        //LODOP.SET_SHOW_MODE("MESSAGE_PARSING_URL","");//该语句隐藏进度条或修改提示信息
        LODOP.PREVIEW();
    }
    function PrintNoBorderTable(url, title) {
        LODOP = getLodop();
        LODOP.PRINT_INIT(title);
        LODOP.ADD_PRINT_URL(20, 5, "100%", "100%", url);
        LODOP.SET_PRINT_STYLEA(0, "LinkedItem", -1);
        LODOP.SET_PREVIEW_WINDOW(2, 2, 0, 760, 540, "");
        LODOP.PREVIEW();
    }
    function PrintBarCodeNoBorderTable(url, title, BarCodeType, Top, Left, Width, Height, BarCodeValue) {
        LODOP = getLodop();
        LODOP.PRINT_INIT(title);
        LODOP.ADD_PRINT_URL(20, 5, "100%", "100%", url);
        LODOP.SET_PRINT_STYLEA(0, "LinkedItem", -1);
        //LODOP.SET_PRINT_PAGESIZE (1, 0, 0,"B5");
        LODOP.ADD_PRINT_BARCODE(Top, Left, Width, Height, BarCodeType, BarCodeValue);
        LODOP.SET_PREVIEW_WINDOW(2, 2, 0, 760, 540, "");
        LODOP.PREVIEW();
    }
    $(function () {
        $('#print').click(function () {
            var val = $(this).attr('val');
            var title = $(this).attr('title');
            var url = '<?php echo APP_HOST; ?>' + val + '?session_id=<?php echo session_id(); ?>&r=' + Math.random() + '&' + $('form').serialize();
            console.log(url);
            PrintNoBorderTable(url, title);
        });
        $('.print').click(function () {
            var num = $(this).attr('num');
            var val = $(this).attr('val');
            var title = $(this).attr('title');
            var url = '<?php echo APP_HOST; ?>' + val + '&session_id=<?php echo session_id(); ?>&r=' + Math.random();
            //val = val;
            console.log(url);
            PrintBarCodeNoBorderTable(url, title, '128Auto', 10, 500, 240, 40, num);
        });
    });
</script>  
{block name="foot_js"}{/block}