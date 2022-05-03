<?php
namespace Home\Controller;
use Think\Controller;
class BeitouController extends Controller { 

	 function __construct(){ 
        parent::__construct(); 
	}  
/*
倍投 50元起
*/
	function beitou(){ 
			$year=2016+I('request.year');
			$jztables=M('jztable')->where("code=000011 and  time>='".$year."-09-15' and  time<='".($year+1)."-09-14'")->order('time asc')->select();//
			// echo M('jztable')->_sql(); 
			$ci=0;//第一次
			$type=1;//买入 
			$zongfen=0;
			$pre_rzzl=0;//上一个买入时的日增长率 
			foreach ($jztables as $key => $value) { 
				$mi=pow(2,$ci);
				$rzzl+=$value['rzzl'];
				if ($value['rzzl']+$pre_rzzl>=2) {//比上一次买入时的日增长率大2个点
					if($ci>0){//有买入才能卖出
						$type=2;
						//全部卖出 
						$zonge=round($zongfen*$value['ljjz'],2);//总额
						$sxf=$zonge*0.005;//手续费
						$jyjl = array('type' =>$type ,'code'=>'000011','jy_time'=>$value['time'],'ok_fene'=>$zongfen,'ok_amount'=>$zonge-$sxf,'ok_time'=>$value['time'],'ok_jz'=>$value['ljjz'],'sxf'=>$sxf,'uc_id'=>1 );
						$id=M('jiaoyijilu')->add($jyjl);
						//倍投下一个周期重新开始
						$ci=0;
						$zongfen=0;  
						$pre_rzzl=0;
						$type=1;
					}
				}else if($pre_rzzl+$value['rzzl']<$ci*-2){//跌一个倍数了，可以买入
					$fen=round(($mi*50*(1-0.0015))/$value['ljjz'],2);
					$jyjl = array('type' =>$type ,'code'=>'000011','jy_time'=>$value['time'],'ok_fene'=>$fen,'ok_amount'=>$mi*50*(1-0.0015),'ok_time'=>$value['time'],'ok_jz'=>$value['ljjz'],'sxf'=>$mi*50*0.0015,'uc_id'=>1 );
					$id=M('jiaoyijilu')->add($jyjl);
					$zongfen+=$fen; 
					$pre_rzzl=0;
					// echo '---';
					$ci++;
				}else if($ci==0){//周期结束第一次开始
					$fen=round(($mi*50*(1-0.0015))/$value['ljjz'],2);
					$jyjl = array('type' =>$type ,'code'=>'000011','jy_time'=>$value['time'],'ok_fene'=>$fen,'ok_amount'=>$mi*(1-0.0015),'ok_time'=>$value['time'],'ok_jz'=>$value['ljjz'],'sxf'=>$mi*50*0.0015,'uc_id'=>1 );
					$id=M('jiaoyijilu')->add($jyjl);
					$zongfen+=$fen; 
					$pre_rzzl=0;
					// echo '---';
					$ci++;
				}else{ //其他情况日增长率累加 
					//其他情况日增长率累加
					$pre_rzzl+=$value['rzzl'];
				}

				if ($type==1) { //买入
					
				}else{
				}
			} 
	}

/*
倍投 2000元起 第4个周期割肉，涨跌3个点操作
*/
	function beitou_gerou(){ 
			$year=2016+I('request.year');
			$jztables=M('jztable')->where("code=000011 and  time>='".$year."-09-15' and  time<='".($year+1)."-09-14'")->order('time asc')->select();
			echo M('jztable')->_sql(); 
			$ci=0;//第一次
			$type=1;//买入 
			$zongfen=0;
			$pre_rzzl=0;//上一个买入时的日增长率 

			foreach ($jztables as $key => $value) { 
				$mi=pow(2,$ci);
				$rzzl+=$value['rzzl'];
				if ($value['rzzl']+$pre_rzzl>=3) {//比上一次买入时的日增长率大2个点
					if($ci>0){//有买入才能卖出
						$type=2;
						//全部卖出 
						$zonge=round($zongfen*$value['ljjz'],2);//总额
						$sxf=$zonge*0.005;//手续费
						$jyjl = array('type' =>$type ,'code'=>'000011','jy_time'=>$value['time'],'ok_fene'=>$zongfen,'ok_amount'=>$zonge-$sxf,'ok_time'=>$value['time'],'ok_jz'=>$value['ljjz'],'sxf'=>$sxf,'uc_id'=>1 );
						$id=M('jiaoyijilu')->add($jyjl);
						//倍投下一个周期重新开始
						$ci=0;
						$zongfen=0;  
						$pre_rzzl=0;
						$type=1;
					}
				}else if($pre_rzzl+$value['rzzl']<$ci*-3){//跌一个倍数了，可以买入
					if($ci<=3){
						$fen=round(($mi*2000*(1-0.0015))/$value['ljjz'],2);
						$jyjl = array('type' =>$type ,'code'=>'000011','jy_time'=>$value['time'],'ok_fene'=>$fen,'ok_amount'=>$mi*2000*(1-0.0015),'ok_time'=>$value['time'],'ok_jz'=>$value['ljjz'],'sxf'=>$mi*2000*0.0015,'uc_id'=>1 );
						$id=M('jiaoyijilu')->add($jyjl);
						$zongfen+=$fen; 
						$pre_rzzl=0;
						// echo '---';
						$ci++;
					}else{//第四个周期卖出
						$type=2;
						//全部卖出 
						$zonge=round($zongfen*$value['ljjz'],2);//总额
						$sxf=$zonge*0.005;//手续费
						$jyjl = array('type' =>$type ,'code'=>'000011','jy_time'=>$value['time'],'ok_fene'=>$zongfen,'ok_amount'=>$zonge-$sxf,'ok_time'=>$value['time'],'ok_jz'=>$value['ljjz'],'sxf'=>$mi*2000*0.005,'uc_id'=>1 );
						$id=M('jiaoyijilu')->add($jyjl);
						//倍投下一个周期重新开始
						$ci=0;
						$zongfen=0;  
						$pre_rzzl=0;
						$type=1;
					}
				}else if($ci==0){//周期结束第一次开始
					$fen=round(($mi*2000*(1-0.0015))/$value['ljjz'],2);
					$jyjl = array('type' =>$type ,'code'=>'000011','jy_time'=>$value['time'],'ok_fene'=>$fen,'ok_amount'=>$mi*2000*(1-0.0015),'ok_time'=>$value['time'],'ok_jz'=>$value['ljjz'],'sxf'=>$mi*2000*0.0015,'uc_id'=>1 );
					$id=M('jiaoyijilu')->add($jyjl);
					$zongfen+=$fen; 
					$pre_rzzl=0; 
					$ci++;
				}else{ //其他情况日增长率累加 
					//其他情况日增长率累加
					$pre_rzzl+=$value['rzzl'];
				}  
			} 
	}
	function beitoutongji(){ 
			$year=2016+I('request.year');  
			$jztables=M('jiaoyijilu')->where("code=000011 and  jy_time>='$year-09-15' and  jy_time<='".($year+1)."-09-14' and type=2")->order('ok_amount asc')->select();  
			$zhouqicount=count($jztables); 
			$max=1; 
			foreach ($jztables as $key => $value) {
				if($value['ok_amount'] >=25&&$value['ok_amount'] <=75){//50
					$max=max(1,$max);
					$zhouqi[0]++;
				}
				else if($value['ok_amount'] >=75&&$value['ok_amount'] <=175){//150
					$max=max(2,$max);
					$zhouqi[1]++;

				}
				else if($value['ok_amount'] >=175&&$value['ok_amount'] <=650){//350
					$max=max(3,$max);
					$zhouqi[2]++;

				}
				else if($value['ok_amount'] >=650&&$value['ok_amount'] <=1000){//750
					$max=max(4,$max);
					$zhouqi[3]++;

				}
				else if($value['ok_amount'] >=1000&&$value['ok_amount'] <=2800){//1550
					$max=max(5,$max);
					$zhouqi[4]++;

				}
				else if($value['ok_amount'] >=2800&&$value['ok_amount'] <=6800){//3150
					$max=max(6,$max);
					$zhouqi[5]++;

				}
				else if($value['ok_amount'] >=6800&&$value['ok_amount'] <=10000){//6350
					$max=max(7,$max);
					$zhouqi[6]++;

				}
				else if($value['ok_amount'] >=10000&&$value['ok_amount'] <=18750){//12750
					$max=max(8,$max);
					$zhouqi[7]++;

				}
				else if($value['ok_amount'] >=18750&&$value['ok_amount'] <=312000){//25550
					$max=max(9,$max);
					$zhouqi[8]++;

				}
				else if($value['ok_amount'] >=312000&&$value['ok_amount'] <=812000){//512000-50
					$max=max(10,$max);
					$zhouqi[9]++;

				}else{
					$max=max(11,$max);

				}

			} 
			// dump($zhouqi);
			file_put_contents("test.txt","\n".$year."\n最大倍数 ".$max."，一年里".$zhouqicount."个周期\n",FILE_APPEND);
			foreach ($zhouqi as $key => $value) {
				if($value>0)
				file_put_contents("test.txt",((pow(2,($key+1)))*50-50).' '.$value."\n",FILE_APPEND);
			} 
//最后一次卖出时间，用于统计
			$lasttime=M('jiaoyijilu')->field('jy_time')->where("code=000011 and  jy_time>='$year-09-15' and  jy_time<='".($year+1)."-09-14' and type=2")->limit(1)->order('jy_time desc')->select();
// dump($lasttime);die();
			$sum2=M('jiaoyijilu')->field(['sum(ok_amount) as sum'])->where("code=000011 and  jy_time>='$year-09-15' and  jy_time<='".$lasttime[0]['jy_time']."' and type=2")->order('ok_amount asc')->select();
			$sum1=M('jiaoyijilu')->field('sum(ok_amount) as sum')->where("code=000011 and  jy_time>='$year-09-15' and  jy_time<='".($year+1)."-09-14' and type=1")->order('ok_amount asc')->select();
			//最后一次卖出后面的买入不算
			$busuan=M('jiaoyijilu')->field('sum(ok_amount) as sum')->where("code=000011 and  jy_time>'".$lasttime[0]['jy_time']."' and  jy_time<='".($year+1)."-09-14' and type=1")->order('ok_amount asc')->select(); 
			 // dump($busuan[0]['sum']);
				file_put_contents("test.txt","赚了".($sum2[0]['sum']-$sum1[0]['sum']+$busuan[0]['sum'])."\n",FILE_APPEND); 

	}
	function beitou_geroutongji(){

			$year=2016+I('request.year');  
			$jztables=M('jiaoyijilu')->where("code=000011 and  jy_time>='$year-09-15' and  jy_time<='".($year+1)."-09-14' and type=2")->order('ok_amount asc')->select();
			// echo M('jiaoyijilu')->_sql();


			$zhouqicount=count($jztables); 
			$max=1; 
			foreach ($jztables as $key => $value) {
				if($value['ok_amount'] >=1000&&$value['ok_amount'] <=3000){//2000
					$max=max(1,$max);
					$zhouqi[0]++;
				}
				else if($value['ok_amount'] >=3000&&$value['ok_amount'] <=8000){//6000
					$max=max(2,$max);
					$zhouqi[1]++;

				}
				else if($value['ok_amount'] >=8000&&$value['ok_amount'] <=20000){//14000
					$max=max(3,$max);
					$zhouqi[2]++;

				}else{
					$max=max(4,$max);

				}

			}  
			file_put_contents("test.txt","\n".$year."\n最大倍数 ".$max."，一年里".$zhouqicount."个周期\n",FILE_APPEND);
			foreach ($zhouqi as $key => $value) {
				if($value>0)
				file_put_contents("test.txt",((pow(2,($key+1)))*2000-2000).' '.$value."\n",FILE_APPEND);
			} 
//最后一次卖出时间，用于统计
			$lasttime=M('jiaoyijilu')->field('jy_time')->where("code=000011 and  jy_time>='$year-09-15' and  jy_time<='".($year+1)."-09-14' and type=2")->limit(1)->order('jy_time desc')->select();
// dump($lasttime);die();
			$sum2=M('jiaoyijilu')->field(['sum(ok_amount) as sum'])->where("code=000011 and  jy_time>='$year-09-15' and  jy_time<='".$lasttime[0]['jy_time']."' and type=2")->order('ok_amount asc')->select();
			$sum1=M('jiaoyijilu')->field('sum(ok_amount) as sum')->where("code=000011 and  jy_time>='$year-09-15' and  jy_time<='".($year+1)."-09-14' and type=1")->order('ok_amount asc')->select();
			//最后一次卖出后面的买入不算
			$busuan=M('jiaoyijilu')->field('sum(ok_amount) as sum')->where("code=000011 and  jy_time>'".$lasttime[0]['jy_time']."' and  jy_time<='".($year+1)."-09-14' and type=1")->order('ok_amount asc')->select(); 
				file_put_contents("test.txt","赚了".($sum2[0]['sum']-$sum1[0]['sum']+$busuan[0]['sum'])."\n",FILE_APPEND); 

	}
	/*
		定时器，每隔30秒调用一次，调用爬虫接口
	*/
	function crontab(){  
		// session_start();  
		// $_SESSION['n']=1;
		if (empty($_SESSION['n']))$_SESSION['n']=-12;
		else $_SESSION['n']++;
// echo $_SESSION['n'];die(); 
		if($_SESSION['n']>=6)die();
 
		header('Content-Type:text/html; charset=utf-8'); 
		     $html=file_get_contents("http://192.168.1.7/home/beitou/beitou_gerou/year/".$_SESSION['n']);//获取页面内容
		     $html=file_get_contents("http://192.168.1.7/home/beitou/beitou_geroutongji/year/".$_SESSION['n']);//获取页面内容
  	
  	}


}