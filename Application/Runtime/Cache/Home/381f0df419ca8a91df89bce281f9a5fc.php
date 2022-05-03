<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Gosh Home管理后台</title>
    <!-- Tell the browser to be responsive to screen width -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
   <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>

<!-- 
<link href="/Public/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
<script src="/Public/plugins/daterangepicker/moment.min.js" type="text/javascript"></script>
<script src="/Public/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
 -->

<link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css"  >
 <style type="text/css">
 	.form-control {
		 display: inline; 
	}
	td{padding: 0 15px 5px}
  </style>

</head>
<body> 
<span style="color:#f33">别搞同一天多次卖出这种，买入+卖出这种也别搞</span> 
<form action="" method="post" ><?php echo ($_GET['code']); ?>
	基金：<?php echo ($codename); ?><br>日增长率 <span <?php if($rzzl < 0 ): ?>style="color:green" > 
       <?php else: ?>style="color:red" ><?php endif; ?> <?php echo ($rzzl); ?>%</span>

<div style="width: 100%">
	<input type="hidden" name='uc_id' value=<?php echo (session('user_id')); ?>>
	<input type="hidden" name='rand' value=<?php echo ($rand); ?>>
	<input type="hidden" name='code' value=<?php echo ($_GET['code']); ?>>
	<div style="width: 100%">买入:<input type="radio" checked="checked" value="1" name="type" /> <input class="form-control" style="width:120px;" value="1000" name="ok_amount" onkeyup="this.value=this.value.replace(/[^\d.]/g,'')" onpaste="this.value=this.value.replace(/[^\d.]/g,'')" type="text">元</div>
	<div style="width: 100%">卖出:<input type="radio" value="2" name="type" /> <input class="form-control" style="width:120px;" value="" name="ok_fene" onkeyup="this.value=this.value.replace(/[^\d.]/g,'')" onpaste="this.value=this.value.replace(/[^\d.]/g,'')" type="text">份
	</div><br>
	时间：<input type="text" class="form-control" style="width:180px;" readonly  name="jy_time" id="start_time"  value="<?php echo ($date); ?>">                        <input type="submit" id="sub" style=" width: 30%;margin-left: 15px "  value="确定"/> </form>
       <div class="chart">  <h>业绩走势</h>
              <div id="container1" style="width:200px;height:150px"></div> 
                   </div> 
<div>
	<table>
<tr>
	<td>时间</td>
	<td>类型</td>
	<td>份额</td>
	<td>钱数</td> 
<!-- 	<td>总本金</td> 
	<td>持有收益</td>
	<td>收益率</td> 
	<td>累盈亏</td> 
 --></tr>
	 <?php if(is_array($jiaoyijilulist)): $i = 0; $__LIST__ = $jiaoyijilulist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><tr>
	<td ><?php echo ($list["ok_time"]); ?></td>
	<td><?php if($list["type"] == 1): ?>买入<?php else: ?>卖出<?php endif; ?></td>
	<td><?php echo ($list["ok_fene"]); ?></td>
	<td><?php echo ($list["ok_amount"]); ?></td> 
<!-- 	<td><?php echo ($list["chiyoushouyi"]); ?></td> 
	<td><?php echo ($list["zongbenjin"]); ?></td> 
	<td><?php echo ($list["chiyoushouyilv"]); ?>%</td> 
	<td><?php echo ($list["leijiyingkui"]); ?></td> 
 --></tr><?php endforeach; endif; else: echo "" ;endif; ?>
</table>
</div>
       <script>
$(document).ready(function(){ 
	var d = new Date();
	var str = "<?php echo ($date); ?>";
	$('#start_time').daterangepicker({
		format:"YYYY-MM-DD",
		singleDatePicker: true,
		showDropdowns: true,
		timePicker : false, //是否显示小时和分钟
		minDate:<?php echo ($date); ?>,
		maxDate:'2030-01-01 12:00:00',
		startDate:str,
	    locale : {
            applyLabel : '确定',
            cancelLabel : '取消',
            fromLabel : '起始时间',
            toLabel : '结束时间',
            customRangeLabel : '自定义',
            daysOfWeek : [ '日', '一', '二', '三', '四', '五', '六' ],
            monthNames : [ '一月', '二月', '三月', '四月', '五月', '六月','七月', '八月', '九月', '十月', '十一月', '十二月' ],
            firstDay : 1
        }
	}); 
});

</script>      


        <script src="https://img.hcharts.cn/jquery/jquery-1.8.3.min.js"></script>

        <script src="/Public/js/highcharts/highcharts.js"></script>
        <script src="https://img.hcharts.cn/highcharts/modules/data.js"></script>

       <!--  <script src="/Public/js/highcharts/exporting.js"></script>

        <script src="/Public/js/highcharts/highcharts-zh_CN.js"></script>
  -->



        <script> 
         Highcharts.chart('container1', { 
                chart: {
                    borderWidth: 0,
                    plotBorderWidth: 1,
                    marginTop: 10
                },
                credits: {
                    enabled: false
                },title: {
                    text: null
                },
               legend: {
                   enabled: false
              },
             xAxis: {
                tickAmount: 30,
                tickPixelInterval: 1,
                crosshair: true,
                type: 'datetime',
                dateTimeLabelFormats: {
                    millisecond: '%H:%M:%S.%L',
                    second: '%H:%M:%S',
                    minute: '%H:%M',
                    hour: '%H:%M',
                    day: '%m-%d',
                    week: '%m-%d',
                    month: '%Y-%m',
                    year: '%Y'
                }
            },
            tooltip: {
                xDateFormat: '%Y-%m-%d',
                crosshairs: [{
                    width: 1,
                    color: 'green'
                    },
                    {
                    width: 1,
                    color: 'green'
                }]
            },
            yAxis: {
                allowDecimals:false,
                tickAmount: 8,
                tickPixelInterval: 1,
                title: {
                    text: null
                }
            },
            plotOptions: {
                area: { 
                fillColor: {
                stops: [ 
                    [0, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')],
                    [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                ]
            },
             threshold: null,
             lineWidth: 1
            }
            },series: [{
                type: 'area',
                name: ' ',
                data: <?php echo ($info); ?>
            }]
        }); 

        </script>    
  
</body>
</html>