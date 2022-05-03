<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Gosh Home管理后台</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="viewport" content="width=device-width, initial-scale=1">
 

    <!-- Bootstrap 3.3.4 -->
    <link href="/Public/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- FontAwesome 4.3.0 -->
 	<link href="/Public/bootstrap/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons 2.0.0 --
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="/Public/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
    	folder instead of downloading all of them to reduce the load. -->
    <link href="/Public/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="/Public/plugins/iCheck/flat/blue.css" rel="stylesheet" type="text/css" />   
    <!-- jQuery 2.1.4 -->
    <script src="/Public/plugins/jQuery/jQuery-2.1.4.min.js"></script>
	<script src="/Public/js/global.js"></script>
    <script src="/Public/js/myFormValidate.js"></script>    
    <script src="/Public/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="/Public/js/layer/layer-min.js"></script><!-- 弹窗js 参考文档 http://layer.layui.com/-->
    <script src="/Public/js/myAjax.js"></script>
<link href="/Public/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
<script src="/Public/plugins/daterangepicker/moment.min.js" type="text/javascript"></script>
<script src="/Public/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
         
  <meta name="__hash__" content="dea530082b265a89a8038136708d21a2_9cdf4b7390200fcf1f8f6fb7a936ac3f" /></head>
  <body style="background-color:#ecf0f5;">
  
  
    <!-- jQuery 2.1.4 -->
    <script src="/Public/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<div style="position: fixed;bottom: 60px;z-index: 10000;margin-left:20px;padding:5px">
			<img id="nav" src="http://liangjun.site.cdn130.hnpet.net:8081/d/images/plus.png" width="20px">
		</div> 
<ul id="navc" class="nav-new-li" style="display:none;padding-top: 10px;background: #fa6;    padding-bottom: 10px;    float: left;    padding-left: 20px;    margin-top: 10px;    position: fixed;    bottom: 80px;    z-index: 10000;">		
<li><a href="<?php echo U('home/index/cj/id/100/id2/0');?>">采集</a></li>
<li><a href="<?php echo U('home/Report/lljz') ;?>">统计jj</a></li>
<li><a href="<?php echo U('home/Report/lljz2') ;?>">jj评论</a></li>
<li><a href="<?php echo U('home/Index/add_transaction/code/210009') ;?>">添加交易</a></li>
<li><a href="<?php echo U('home/index/lljz3') ;?>">jj估值</a></li>
<li><a href="<?php echo U('home/Report/dange') ;?>">查看shouy</a></li>
<li><a href="<?php echo U('home/Report/setday') ;?>">设置时间</a></li>
<li><a href="<?php echo U('home/Report/shouyi') ;?>">收益</a></li>
<li><a href="<?php echo U('home/Report/yjzs/code/210009') ;?>">业绩走势</a></li>
</ul>

<script type="text/javascript"> 
		jQuery(document).ready(function($){ 
		$('#nav').click(function(){
			if ($('#nav').attr('src')=='http://liangjun.site.cdn130.hnpet.net:8081/d/images/plus.png') {
				$('#nav').attr('src','http://liangjun.site.cdn130.hnpet.net:8081/d/images/minus.png');$('#navc').toggle(); 
			}else{
				$('#nav').attr('src','http://liangjun.site.cdn130.hnpet.net:8081/d/images/plus.png');$('#navc').toggle(); 
			}

		}); 

			}); 
	</script>

<link href="/Public/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
<script src="/Public/plugins/daterangepicker/moment.min.js" type="text/javascript"></script>
<script src="/Public/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
<div class="wrapper">
    <div class="breadcrumbs" id="breadcrumbs" style="display:none">
	 
</div>

        </section>
		<section class=" ">
		  
          <div class="row">
            <div class="col-md-12">
              <div class="box box-primary"> 
                </div>
                <div class="box-body">
                  <div class="chart">  
            <?php if(is_array($container_list)): $i = 0; $__LIST__ = $container_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><div id="<?php echo ($list); ?>" style="width:200px;height:150px"></div><?php endforeach; endif; else: echo "" ;endif; ?>
                  </div> 
                </div>
              </div>
            </div> 
          </div>
   </section>
</div>

  

        <script src="https://img.hcharts.cn/jquery/jquery-1.8.3.min.js"></script>

        <script src="/Public/js/highcharts/highcharts.js"></script>
        <script src="https://img.hcharts.cn/highcharts/modules/data.js"></script>

        <script src="/Public/js/highcharts/modules/exporting.js"></script>

        <script src="/Public/js/highcharts-plugins/highcharts-zh_CN.js"></script>
 


        <script> 
   <?php if(is_array($infoslist)): $k = 0; $__LIST__ = $infoslist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$infosl): $mod = ($k % 2 );++$k;?>Highcharts.chart('container'+<?php echo ($k); ?>, { 
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
                data: <?php echo ($infosl); ?>
            }]
        });<?php endforeach; endif; else: echo "" ;endif; ?>

        </script> 

​

 
</body>
</html>