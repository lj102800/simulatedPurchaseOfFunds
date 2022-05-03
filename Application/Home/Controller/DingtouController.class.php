<?php
namespace Home\Controller;
use Think\Controller;
class DingtouController extends Controller { 

	 function __construct(){ 
        parent::__construct(); 
	}  
	/*
	定投，先投30万，每次10个点补仓10万，或者赚10个点卖出
	*/
	function dingtou(){  
			$year=2003+I('request.year');
			$jztables=M('jztable')->where("code=000011 and  time>='".$year."-09-15' and  time<='".($year+1)."-09-14' ")->order('time asc')->select();
			// echo M('jztable')->_sql();
  			 $info=file_get_contents("info2.txt");//获取页面内容 
		    $obj_json=json_decode($info);
		    dump($obj_json);//{"ci":0,"type":1,"pre_ok_jz":[0],"fenlist":[0],"pre_amount":[0],"pre_sxf":[0],"zong_fene":0}
		   // die();
			$ci=$obj_json->ci;//第一次
			$type=$obj_json->type;//买入 
			// $pre_rzzl=($obj_json->pre_rzzl);//上一个买入时的日增长率
			$fenlist=($obj_json->fenlist);//上一次买入时的份额 
			$zong_fene=($obj_json->zong_fene);
			$pre_amount=($obj_json->pre_amount);
			$pre_sxf=($obj_json->pre_sxf);
			$pre_ok_jz=($obj_json->pre_ok_jz);
			foreach ($jztables as $key => $value) {  
				// $rzzl+=$value['rzzl'];
				if (round(($value['ljjz']-$pre_ok_jz[$ci])/$value['ljjz'],2)>=0.1) {//比上一次买入时的日增长率大10个点
				// if ($value['ok_jz']+$pre_rzzl[$ci]>=10) {//比上一次买入时的日增长率大10个点
				 if($ci==0){//周期结束第一次开始
					$fenlist[1]=round((300000*(1-0.0015))/$value['ljjz'],2);
						$zong_fene=$fenlist[1];
					$jyjl = array('type' =>$type ,'code'=>'000011','jy_time'=>$value['time'],'ok_fene'=>$fenlist[1],'ok_amount'=>300000*(1-0.0015),'ok_time'=>$value['time'],'ok_jz'=>$value['ljjz'],'sxf'=>300000*0.0015,'uc_id'=>2 ,'zong_fene'=>$zong_fene);
					$id=M('jiaoyijilu')->add($jyjl); 
			// echo M('jiaoyijilu')->_sql();
						// $pre_rzzl[1]=0;
						$pre_amount[1]=300000*(1-0.0015);
						$pre_sxf[1]=300000*0.0015;
						$pre_ok_jz[1]=$value['ljjz'];
						dump($fenlist);
						// dump($pre_rzzl);
					// echo '---';
					$ci=1;
				// }else if($pre_rzzl[$ci]+$value['rzzl']<-$ci*10){//跌10个点了，可以买入 
				}else if($ci>0){//有买入才能卖出
						$type=2;
						//上一次买入的卖出 
						$fen=$fenlist[$ci];
						$zonge=round($fen*$value['ljjz'],2);//总额
						$sxf=$zonge*0.005;//手续费
						$zong_fene-=$fen;
						$shouyi=$zonge-$sxf-$pre_amount[$ci]-$pre_sxf[$ci];//收益=当前确认金额-买入时确认金额-买入时手续费
						$jyjl = array('type' =>$type ,'code'=>'000011','jy_time'=>$value['time'],'ok_fene'=>$fen,'ok_amount'=>$zonge-$sxf,'ok_time'=>$value['time'],'ok_jz'=>$value['ljjz'],'sxf'=>$sxf,'uc_id'=>2 ,'zong_fene'=>$zong_fene,'shouyi'=>$shouyi);
						$id=M('jiaoyijilu')->add($jyjl); 
			// echo M('jiaoyijilu')->_sql();
						// $pre_rzzl[1]=0;

						$pre_amount[$ci]=0;
						$pre_sxf[$ci]=0;
						$fenlist[$ci]=0;;
						$pre_ok_jz[$ci]=0;
						// $pre_rzzl=$value['rzzl'];
						$type=1;
						// $pre_rzzl[$ci]=0;;
						$ci--;//去掉上一次记录
						// for ($i=0; $i <$ci ; $i++) { 
						// 	$pre_rzzl[$i+1]+=$value['rzzl'];//
						// }
					}
				}else if(round(($pre_ok_jz[$ci]-$value['ljjz'])/$pre_ok_jz[$ci],2)>=0.1){//跌10个点了，可以买入 
					// for ($i=0; $i <$ci ; $i++) { //当前买入的不算日增长率
					// 	$pre_rzzl[$i+1]+=$value['rzzl'];//
					// }
					$ci++;
					$fenlist[$ci]=round((100000*(1-0.0015))/$value['ljjz'],2);
						$zong_fene+=$fenlist[$ci];
					$jyjl = array('type' =>$type ,'code'=>'000011','jy_time'=>$value['time'],'ok_fene'=>$fenlist[$ci],'ok_amount'=>100000*(1-0.0015),'ok_time'=>$value['time'],'ok_jz'=>$value['ljjz'],'sxf'=>100000*0.0015,'uc_id'=>2 ,'zong_fene'=>$zong_fene);
					$id=M('jiaoyijilu')->add($jyjl); 

						$pre_amount[$ci]=100000*(1-0.0015);
						$pre_sxf[$ci]=100000*0.0015;
						// $pre_rzzl[$ci]=0;
						$pre_ok_jz[$ci]=$value['ljjz'];
				}else{ //其他情况日增长率累加 
					// for ($i=0; $i <$ci ; $i++) { 
					// 	$pre_rzzl[$i+1]+=$value['rzzl'];//
					// }
				}  
			}

			file_put_contents('info2.txt','{"ci":'.$ci.',"type":'.$type.',"pre_ok_jz":'.json_encode($pre_ok_jz).',"fenlist":'.json_encode($fenlist).',"pre_amount":'.json_encode($pre_amount).',"pre_sxf":'.json_encode($pre_sxf).',"zong_fene":'.$zong_fene.'}');
	}
	 /*
	定投统计
	 */
	function dingtoutongji(){
// {"i":0,"ok_fene":[0],"sxf":[0],"type":[],"ok_amount":[0],"ok_fene":[0],"type":[0]}
			$year=2003+I('request.year');  
			$jztables=M('jiaoyijilu')->where("code=000011 and  jy_time>='$year-09-15' and  jy_time<='".($year+1)."-09-14'")->order('jy_time asc')->select();//dump($jztables);
			// echo M('jiaoyijilu')->_sql(); 
		 	$info=file_get_contents("info.txt");//获取页面内容
		    // dump(json_decode($info));
		    $obj_json=json_decode($info);
		    $zhuanl=0;
			foreach ($jztables as $key => $value) {
				 if ($value['type']==1) { 
				 	$obj_json->i++;
				    $i=$obj_json->i;
				 	$obj_json->sxf[$i]=$value['sxf'];
				 	$obj_json->ok_fene[$i]=$value['ok_fene'];
				 	$obj_json->ok_amount[$i]=$value['ok_amount'];
				 	$obj_json->type[$i]=$value['type'];
				 	dump($obj_json);
				 }else {
				 	$zhuanl+=$value['ok_amount']-$obj_json->ok_amount[$i]-$obj_json->sxf[$i]; 
				 	$obj_json->i--; 
				 }  
			}  
			 // dump($obj_json);
			file_put_contents('info.txt',json_encode($obj_json));
		 	file_put_contents("test.txt",$year."-09-15 ".($year+1)."-09-14 赚了".$zhuanl."\n",FILE_APPEND);
	 
	} 
	/*
	累计盈亏
	参数time
	*/
	function ljyk(){
		$lasttime=I('request.time');  
		$uc_id=I('request.uc_id');  
		// $lasttime=($year+1)."-09-14";
			$jztables=M('jiaoyijilu')->where("code=000011  and  uc_id=$uc_id and jy_time<='".($lasttime)."' ")->order('jy_time desc')->select();//dump($jztables);
			// echo M('jiaoyijilu')->_sql(); 
 
			//查找的最近一天的净值明细
			$lasttable=M('jztable')->where("code=000011 and  `time`<='$lasttime' ")->limit(1)->order('time desc')->select();
			// echo M('jztable')->_sql();  
			// dump($lasttable);
			if (!empty($lasttable)) {
				// echo $jztables[0]['zong_fene'].'---'.$lasttable[0]['ljjz'];
				$current_jine=$jztables[0]['zong_fene']*$lasttable[0]['ljjz'];//当前金额
			}
			//持有收益=(买入时份额)*(现在的累计净值-买入时累计净值)-买入手续费
			$chiyoushouyi=0;
			//持有收益率=总持有收益/总买入金额(买入时金额+买入手续费)
			$zongmairujine=0; 
		    $leijiyingkui=0;//累计盈亏
		    $daoxu=1;  
		    $zhouqijiesu=1;//0为最后一个周期结束
			foreach ($jztables as $key => $value) {
				// echo $key.'<br>';
				if ($jztables[0]['zong_fene']!=0&&$zhouqijiesu==1) {//没有卖光+还在最后一个周期里面
					if ($value['type']==2) {
						if ($daoxu<1) {
							# code...
						}
						$daoxu++;
					}else{
						if ($daoxu<=1) {//大于1的是已经卖出的，不做累计
							echo $value['ok_fene'].'-'.$value['id'].'<br>';
							$chiyoushouyi+=$value['ok_fene']*($lasttable[0]['ljjz']-$value['ok_jz'])-$value['sxf'];	
							$zongmairujine+=$value['ok_amount']+$value['sxf'];
						}
						$daoxu--;
					}
					// if ($value['zong_fene']==0) {
					// 	$zhouqijiesu=1;
					// }

				}
				if($value['zong_fene']==0){
					if ($key!=0) {
						$zhouqijiesu=0;
					}
				} 
				 if ($value['type']==2) {
				 	 $leijiyingkui+=$value['shouyi']; 
				 }  
			} 
				// echo $zongmairujine.'---'.round($chiyoushouyi,2);
			$chiyoushouyilv=round($chiyoushouyi/$zongmairujine,4)*100;
			echo $lasttime.'<br>';
			echo '当前金额'.round($current_jine,2).'<br>';
			echo '持有收益'.round($chiyoushouyi,2).'<br>';
			echo '持有收益率'.$chiyoushouyilv.'%<br>';
			echo '累计盈亏'.round(($leijiyingkui+$chiyoushouyi),2).'<br>'; 
	}
	/*
		定时器，每隔30秒调用一次，调用爬虫接口
	*/
	function crontab(){   
		if (empty($_SESSION['n']))$_SESSION['n']=1;
		else $_SESSION['n']++; // $_SESSION['n']=1;
 
		header('Content-Type:text/html; charset=utf-8'); 
		      // $html=file_get_contents("http://192.168.1.7/home/dingtou/dingtou/year/".$_SESSION['n']);//获取页面内容
		     $html=file_get_contents("http://192.168.1.7/home/dingtou/dingtoutongji/year/".$_SESSION['n']);//获取页面内容 
		  // for ($i=2004; $i <=2022 ; $i++) { 
				// echo "<br>http://124.223.181.223/home/dingtou/ljyk/time/$i-10-16<br>";
				// echo $html=file_get_contents("http://124.223.181.223/home/dingtou/ljyk/time/$i-10-16");//获取页面内容

		  // }
  	} 


}