<?php
namespace Home\Controller;
use Think\Controller;
use Common\Util;
 
class ReportnController extends Controller {
	public function index(){
		$this->display(); 
	}
	 function __construct(){ 
        parent::__construct();
		session_start();  
		
		$userid=$_GET['user_id'];$_SESSION['user_id']=2;	
		if (empty($userid)){
			if (empty($_SESSION['user_id']))$_SESSION['user_id']=1;			
			$userid=$_SESSION['user_id']; 
		}
		$user=M('users')->where("id=$userid")->find();
		$this->assign('user',$user['name']); 
		$this->assign('time',$_SESSION['today']);
	}

	public function setday(){ 
		$users=M('users')->select();
		$this->assign('users',$users);  
		 
		$today=I('request.today');
		$user_id=I('request.user_id'); 
		if(!empty($today))
		$_SESSION['today']=$today;
		if(!empty($user_id))
		$_SESSION['user_id']=$user_id;
		 
		
		$this->display();
	}
	/*
	累计净值，看一年，三年，五年，的走势图
	*/
	public function lljz(){
/*SET @add_sal=0;    
SELECT time, rzzl, @add_sal := @add_sal + rzzl AS add_sal  
  FROM jj_jztable   where code=180012 
 ORDER BY time ; 

(select sum(rzzl), code from `jj_jztable` where time<='2017-12-05' and time>='2012-12-05' group by code order by code)
union 
(select sum(rzzl),'2016-12-05',code from `jj_jztable` where time<='2016-12-05' and time>='2015-12-05' group by code order by code)

(select  name,a.code,sum(rzzl),count(*)/246 ,sum(rzzl)/(count(*)/246)    from `jj_jztable` as a join `jj_code` as c on  a.code=c.code group by code order by code)
select sum(rzzl),'2017-12-05',count(*),code from `jj_jztable` where code='150023' and time<='2017-12-05' and time>='2016-12-05' 
*///		echo I('request.code');; 
		$code=I('request.code');; 
		$con['rzzl']=3;
		$p=2;
//		$where="(rzzl>=$p or rzzl<=-$p) and ";
//		$where="`time` between '2017-08-2' and '2017-09-15' and ";
		if (!empty($code)){
				$where.="`code` ='$code' and ";
		}

		$begin= I('request.begin');
		$end=I('request.end');
		if (!empty($begin)&&!empty($end))
			$where.="`time` between '$begin' and '$end'";
			else{
//			$where.="`time` between '".$_SESSION['today']."' and '".date("Y-m-d",strtotime("+1months",strtotime($_SESSION['today'])))."'";
		$today=time();//
//		$today=strtotime($_SESSION['today']);//time()
		$month=date("Y-m-d", strtotime("-1 months", $today));
		$year=date("Y-m-d", strtotime("-1 year", $today));
		$threeyear=date("Y-m-d", strtotime("-3 year", $today));
		$f4year=date("Y-m-d", strtotime("-4 year", $today));
		$fiveyear=date("Y-m-d", strtotime("-5 year", $today));
		$f6year=date("Y-m-d", strtotime("-6 year", $today));
		$f7year=date("Y-m-d", strtotime("-7 year", $today));
		$f8year=date("Y-m-d", strtotime("-8 year", $today));
		$f9year=date("Y-m-d", strtotime("-9 year", $today));
		$f10year=date("Y-m-d", strtotime("-10 year", $today));
		$f11year=date("Y-m-d", strtotime("-11 year", $today));
		$f12year=date("Y-m-d", strtotime("-12 year", $today));
		if (I('request.startime')==0)
		$where.="`time` >'$month' and ";
		else if (I('request.startime')==1)
		$where.="`time` >'$year' and ";
		else if (I('request.startime')==3)
//		$where.="`time` >'$threeyear' and ";
//		$where.="`time` >'$f6year' and `time` <'$threeyear' and ";
//		$where.="`time` >'$f9year' and `time` <'$f6year' and ";
		$where.="`time` >'$f12year' and `time` <'$f9year' and ";
		else if (I('request.startime')==5)
		$where.="`time` >'$fiveyear' and ";
//		if (I('request.rzzl')==1)
//		$where.="`rzzl` >1 and ";
//		else if (I('request.rzzl')==2)
//		$where.="`rzzl` >2 and ";
//		else if (I('request.rzzl')==3)
//		$where.="`rzzl` >3 and ";
//		else if (I('request.rzzl')==4)
//		$where.="`rzzl` >4 and ";
//		else if (I('request.rzzl')==-4)
//		$where.="`rzzl` <-4 and ";
//		else if (I('request.rzzl')==-3)
//		$where.="`rzzl` <-3 and ";
//		else if (I('request.rzzl')==-2)
//		$where.="`rzzl` <-2 and ";
//		else if (I('request.rzzl')==-1)
//		$where.="`rzzl` <-1 and ";
		$where.="1=1";}
//		echo $where;
dump($where);
//		$where.="`code`=".I('request.code')."  ";;
//		$con['code']=I('request.code');; 
		$limit=365*3;
		$new =M('jztable')->where( $where )->order('time desc')->select();
		echo M('jztable')->_sql();
		$v=0;//dump($new);
	$s="[";
		for ($i=count($new)-1;$i>=0;$i--){
				$v+=$new[$i]['rzzl'];
				$brr[] = $v;
				$day[] =$new[$i]['time'];
			if ($i!=count($new)-1)$s.=",";
			$s.="[Date.UTC(".gmdate('Y,m,d', (strtotime($new[$i]['time'])-30*24*3600))."),$v]";
		}
//		dump($b);
//		dump($brr);
		$result = array('data'=>$brr,'time'=>$day,'title'=>'汇丰晋信大盘股票A'); 
//		dump($result);die;
	$infos=array();
	
		for ($i=0;$i<4;$i++){
			$info[]="Date.UTC(".date('Y-m-d D', 1474551791).")";
			$info[]=$i;
			$info[]=$i*$i;
			$infos[]=$info;
			if ($i!=0)$s.=",";
//			$s.="[Date.UTC(".gmdate('Y,m,d', 1474551791)."),$i]";
		}
		$s.="]";
		$this->assign('infos',$s);
//		$this->assign('infos',json_encode($infos));
		$this->assign('result',json_encode($result));
		$width=$limit*10;
		$this->assign('width',$width);
		$limit=8;
		$new =M('jztable')->where("$where  ")->limit($limit)->order('id desc')->select();
		$v=0;
		for ($i=count($new)-1;$i>=0;$i--){ 
				$v+=$new[$i]['rzzl'];
				$brr2[] = $v;
				$day2[] =$new[$i]['time'];			
		}  
		$result2 = array('data'=>$brr2,'time'=>$day2,'title'=>'金鹰核心资源混合'); 
//		dump($result2);
		$this->assign('result2',json_encode($result2));
		$width=$limit*10; 
		$this->assign('width2',$width);
		
		
		
		$userid=1;
		$list=M('user_code')->alias('a')
		->join('left join jj_code as b on b.code=a.code')->
		where("a.user_id=$userid and selected=1")->order('attention desc')->select();
//$list=M()->sql();
		$this->assign('list',$list);
//		dump($list);
//		$this->assign('result2','210009');
		$this->display(); 
	}
	/*
		业绩走势
	*/
	 public function yjzs(){
 		$code=I('request.code');; 
		$con['rzzl']=3;
		$p=2;
		if (!empty($code)){
				$where.="`code` ='$code' and ";
		}

		$begin= I('request.begin');
		$end=I('request.end');
		if (!empty($begin)&&!empty($end))
			$where.="`time` between '$begin' and '$end'";
			
		// $today=time();//
		// $month=date("Y-m-d", strtotime("-1 months", $today));
		// $where.="`time` >'$month' and ";
		// $where.="1=1";
		// $limit=365*6;
		// $new =M('jztable')->where( $where )->limit($limit)->order('time desc')->select();
		$new =M('jztable')->where( $where )->order('time desc')->select();
		echo M('jztable')->_sql().'<br>';

		$v=0;//dump($new);
		$s="[";
		// $first['time']=date("Y-m-d", time());
		// $first['rzzl']=0;
		// array_unshift($new, $first);
		for ($i=count($new)-1;$i>=0;$i--){
				$brr[] = $v;
				$day[] =$new[$i]['time'];
			if ($i!=count($new)-1)$s.=",";
			$s.="[Date.UTC(".gmdate('Y,m,d', (strtotime($new[$i]['time'])-30*24*3600))."),$v]";
				$v+=$new[$i]['rzzl'];
		}
	
		$s.="]";dump($s);
		$this->assign('infos',$s);
		$width=$limit*10;
		// $this->assign('width',$width);
		$this->assign('width',3660);
		$limit=8;
		$this->display(); 
	} 
	/*
	当前用户收益情况
	*/

	public function dange(){   
		$t=new \Home\Common\Util\Transaction();
//		$mcll=0.005;//0.005 卖出利率
//		$mrll=0.0015 ;//0.0015 买入利率
		$t->code='161720';
		$c=M('code')->where('code='.$t->code)->find();
		$t->mcll=$c['maichulv'];//0.005 卖出利率
		$t->mrll=$c['mairulv'];//0.0015 买入利率
		echo '<br><br>';
		$userid=1;//->Field('sum(money)')
//		$t->begin='2017-08-08';
//		$t->end='2017-09-08';		
//		$where="and `time` between '$t->begin' and '$t->end'";
		$list=M('transaction')->where("user_id=$userid and code=$t->code  ")->order('time')->select();
//		echo M('transaction')->_sql();
//dump($list);
		$today["money"] =0;
	    $today["type"] =-1;
	    $today["time"] =date("Y-m-d");
	    $list[]=$today;
// 		echo M('transaction')->_sql().'<br>';
// dump($list);
		$t->sum=0;
		$t->gain=0;
		$t->mairu=0;
		$t->maichu=0;
		$t->drsy=0;
//		$t->sum2=0;//同一天多次购买
		$t->sunfen=0;
		$t->maifen=0;
		$t->sumdrsy=0;
		$t->mairusxf=0;
		$t->fen=0;
		$t->fen2=0;
		
//		$list=$t->getMoniList(8,$t->code,"2016-09-11 12:00:00","2017-09-11 12:00:00");
//		dump($list);
		$syList=$t->getlist($list);
//		dump($syList);
		$this->assign('syList',$syList);
		$this->assign('sum',$t->sum);
		$this->assign('gain',$t->sumdrsy);
		
		$this->display();
		
	} 
	
/*
收益
必须参数user_id =2
*/
	public function shouyi2(){ 
		// $t=new \Home\Common\Util\gjPhone();
		
		$endtime=date('2017-9-28');;
//		$endtime=date('Y-m-d',time());;
		//设置最后一天
		$e=M('jztable')->where("time<='$endtime'")->order('time desc')->find();
		$endtime=$e['time'];
		$t=new \Home\Common\Util\Transaction();
		$userid=$_GET['user_id'];
		if (empty($userid))
		$userid=$_SESSION['user_id']; 
		
		if (!S($userid.'syList')){ 
			$codes=M('transaction')->group('code')->where('user_id='.$userid)->select();
echo			M('transaction')->_sql();
			for ($i=0;$i<count($codes);$i++){
				$code=$codes[$i]['code'];  
				$t->code=$code;
				$c=M('code')->where('code='.$code)->find();
				$t->mcll=$c['maichulv'];//0.005 卖出利率
				$t->mrll=$c['mairulv'];//0.0015 买入利率

				$list=M('transaction')->where("user_id=$userid and code=$code  ")->order('time')->select();
				$today["money"] =0;
			    $today["type"] =-1;
			    $today["time"] =date("Y-m-d");
			    $list[]=$today;
				$t->sum=0;
				$t->gain=0;
				$t->mairu=0;
				$t->maichu=0;
				$t->drsy=0;
				$t->sunfen=0;
				$t->maifen=0;
				$t->sumdrsy=0;
				$t->mairusxf=0;
				$t->fen=0;
				$t->fen2=0;
				$t->updateSellFen($list);
			
				
				$t->updateUse2($userid,$code);
				$year=date("Y-m-d", strtotime("-1 year", $endtime));
				$syList[]=$t->getZhouqi($userid,$code,$year,$endtime);
			} 
			S($userid.'syList',$syList,60*60*12);
		}
		$syList=S($userid.'syList');;
//		for ($i=0;$i<count($syList);$i++){
//			
//		}
		$money=0;$chiyje=0;$shouyi=0;$syl=0;$money1=0;$money2=0;$shouyi2=0;
		for ($i=0;$i<count($syList);$i++){
			if (!S('gszf'.$syList[$i]['code'])){
				$t=date("Y-m-d", strtotime( $endtime ." -1 week"));
				$rzzl=M('jztable')->field('sum(rzzl) as rzzl,code')->where("code=".$syList[$i]['code']." and time between '$t' and '$endtime'")->group('code')->find();
				$syList[$i]['zhoull']=$rzzl['rzzl'];
				$t=date("Y-m-d", strtotime($endtime ." -1 months"));
				$rzzl=M('jztable')->field('sum(rzzl) as rzzl,code')->where("code=".$syList[$i]['code']." and time between '$t' and '$endtime'")->group('code')->find();
				$syList[$i]['yuell']=$rzzl['rzzl'];
				$chiyje+=$syList[$i]['chiyje'];
				$money1+=$syList[$i]['money1'];
				$money2+=$syList[$i]['money2'];
				$money+=$syList[$i]['money'];
				$shouyi2+=$syList[$i]['shouyi2'];
				$shouyi1+=$syList[$i]['shouyi1'];
				$syList[$i]['syl']=round(($syList[$i]['chiyje']-$syList[$i]['money'])*100/$syList[$i]['money'],2);//
				$syList[$i]['ljsyl']=round(($syList[$i]['shouyi2'])*100/$syList[$i]['money2'],2);//
				
				$imgPath = "http://j4.dfcfw.com/charts/pic6/".$syList[$i]['code'].".png?v=";
				$gjPhone = new \Home\Common\Util\gjPhone($imgPath);
				//进行颜色分离
				$gjPhone->getHec();
				//画出横向数据
				$Data=$gjPhone->magHorData2();
				S('gszf'.$syList[$i]['code'],$Data,60);
			}
			$syList[$i]['gszf']=S('gszf'.$syList[$i]['code']);;
		}
		 
		//排序
//		dump($syList);
//		$syList=$this->quickSort($syList,'gszf');
		$this->assign('syList',$syList); 
		
 		$this->assign('syList2',$syList['syList2']);
		$this->assign('money',$money);
		$this->assign('shouyi',$shouyi);
		$this->assign('money1',$money1);
		$this->assign('shouyi1',$shouyi1);
		$this->assign('money2',$money2);
		$this->assign('shouyi2',$shouyi2); 
		$this->assign('chiyje',$chiyje); 
		$this->assign('syl',$syl); 
//		$this->display('shouyi2_pc');
		$this->display();
		
	}
	/*
买时参考
	*/
	public function msck(){   
		/*
SELECT a.*,b.rzzl FROM jj_msck a left join 
(select * from jj_jztable as c 
where (c.code in (162411,501018) and c.time='2017-11-28') or 
(c.code not in (162411,501018) and c.time='2017-11-29')) as b on b.code=a.code
 WHERE ( `show`>=0 and a.time='2017-11-30' ) 
 ORDER BY `show` asc,a.id asc

		*/
 		$da = date("w");

		if( $da == "1" ){  
			$d=date("Y-m-d",strtotime("-3 day")); 
		}else
			$d=date("Y-m-d",strtotime("-1 day"));
		if( $da == "1" ){  
			$d2=date("Y-m-d",strtotime("-4 day"));
		}else if( $da == "2" ){  
			$d2=date("Y-m-d",strtotime("-4 day"));
		}else
			$d2=date("Y-m-d",strtotime("-2 day"));
			$d2='2017-11-28';
			$d1='2017-11-29';
			$d='2017-11-30';

		$syList=M('msck')->alias('a')->field('a.*,b.rzzl')->
		join("left join (select * from jj_jztable as c where (c.code in (162411,501018) and c.time='$d2') or (c.code not in (162411,501018) and c.time='$d')) as b on b.code=a.code")->
		where("`show`>=0 and a.time='2017-11-30' ")
		// where("`show`>=0 and a.time='".date("Y-m-d") ."' ")
		->order('`show` asc,a.id asc')->select(); 
		// echo M('msck')->_sql();
//		$syList=M('msck')->alias('a')->field('a.*,b.rzzl')->
//		join("left join jj_jztable as b on b.code=a.code and b.time='$d'")->
//		where("`show`>=0 and a.time='".date("Y-m-d") ."' ")->order('`show` asc,a.id asc')->select(); 
		/*
		计算年利率
		select ljjz,code,time from `jj_jztable` where time='2016-11-18' or time='2017-11-20' order by code
		 */
	
 		$da = date("w");
		if( $da == "1" ){  
			$d=date("Y-m-d",strtotime("-4 day")); 
		}else if( $da == "2" ){  
			$d=date("Y-m-d",strtotime("-4 day"));
		}else
			$d=date("Y-m-d",strtotime("-2 day"));
		/*---------------------------------------*/
		//1
		$dd=date("w",strtotime("-1 day -1 year ")); 
		$i=0;
		while ($dd<1||$dd>5){//是工作日
			$i++;
			$dd=date("w",strtotime("$i day -1 year "));
		}
		$i=-1+$i;
		$dd=date("Y-m-d",strtotime("$i day -1 year "));
		
		$list=M('jztable')->field('ljjz,code,time')->
		where("time='$dd' or time='$d'")->order('`code` asc, time asc')->select();
//		echo M('jztable')->_sql();
//		dump($list);
		for ($i=0;$i<count($list);$i++){
			if ($list[$i+1]['code']!=$list[$i]['code'])continue;
			$ljjz['1'.$list[$i+1]['code']]=round(($list[$i+1]['ljjz']-$list[$i]['ljjz'])/$list[$i]['ljjz'],2)*100;
			$i++;
		}
		/*---------------------------------------*/
		//3
		 $dd=date("w",strtotime("-1 day -3 year ")); 
		$i=-1;
		while ($dd<1||$dd>5){//是工作日
			$i++;
			 $dd=date("w",strtotime("$i day -3 year "));
		} 
		$dd=date("Y-m-d",strtotime("$i day -3 year "));
		
		$list=M('jztable')->field('ljjz,code,time')->
		where("time='$dd' or time='$d'")->order('`code` asc, time asc')->select();
//		echo M('jztable')->_sql();
//		dump($list);
		for ($i=0;$i<count($list);$i++){
			if ($list[$i+1]['code']!=$list[$i]['code'])continue;
			$ljjz['3'.$list[$i+1]['code']]=round(($list[$i+1]['ljjz']-$list[$i]['ljjz'])/$list[$i]['ljjz'],2)*100;
			$i++;
		}
		/*---------------------------------------*/
		//5
		$dd=date("w",strtotime("-1 day -5 year ")); 
		$i=-1;
		while ($dd<1||$dd>5){//是工作日
			$i++;
			$dd=date("w",strtotime("$i day -5 year "));
		} 
		$dd=date("Y-m-d",strtotime("$i day -5 year "));
		
		$list=M('jztable')->field('ljjz,code,time')->
		where("time='$dd' or time='$d'")->order('`code` asc, time asc')->select();
//		echo M('jztable')->_sql();
//		dump($ljjz);
		for ($i=0;$i<count($list);$i++){
			if ($list[$i+1]['code']!=$list[$i]['code'])continue;
			$ljjz['5'.$list[$i+1]['code']]=round(($list[$i+1]['ljjz']-$list[$i]['ljjz'])/$list[$i]['ljjz'],2)*100;
			$i++;
		}
		/*---------------------------------------*/
		//7
		$dd=date("w",strtotime("-1 day -7 year ")); 
		$i=-1;
		while ($dd<1||$dd>5){//是工作日
			$i++;
			$dd=date("w",strtotime("$i day -7 year "));
		} 
		$dd=date("Y-m-d",strtotime("$i day -7 year "));
		
		$list=M('jztable')->field('ljjz,code,time')->
		where("time='$dd' or time='$d'")->order('`code` asc, time asc')->select();
//		echo M('jztable')->_sql();
//		dump($ljjz);
		for ($i=0;$i<count($list);$i++){
			if ($list[$i+1]['code']!=$list[$i]['code'])continue;
			$ljjz['7'.$list[$i+1]['code']]=round(($list[$i+1]['ljjz']-$list[$i]['ljjz'])/$list[$i]['ljjz'],2)*100;
			$i++;
		}
		/*---------------------------------------*/
		//9
		$dd=date("w",strtotime("-1 day -9 year ")); 
		$i=-1;
		while ($dd<1||$dd>5){//是工作日
			$i++;
			$dd=date("w",strtotime("$i day -9 year "));
		}
		$i=-1+$i;
		$dd=date("Y-m-d",strtotime("$i day -9 year "));
		
		$list=M('jztable')->field('ljjz,code,time')->
		where("time='$dd' or time='$d'")->order('`code` asc, time asc')->select();
//		echo M('jztable')->_sql();
//		dump($ljjz);
		for ($i=0;$i<count($list);$i++){
			if ($list[$i+1]['code']!=$list[$i]['code'])continue;
			$ljjz['9'.$list[$i+1]['code']]=round(($list[$i+1]['ljjz']-$list[$i]['ljjz'])/$list[$i]['ljjz'],2)*100;
			$i++;
		}
		/*---------------------------------------*/
		//11
		$dd=date("w",strtotime("-1 day -11 year ")); 
		$i=-1;
		while ($dd<1||$dd>5){//是工作日
			$i++;
			$dd=date("w",strtotime("$i day -11 year "));
		}
		$i=-1+$i;
		$dd=date("Y-m-d",strtotime("$i day -11 year "));
		
		$list=M('jztable')->field('ljjz,code,time')->
		where("time='$dd' or time='$d'")->order('`code` asc, time asc')->select();
//		echo M('jztable')->_sql();
//		dump($ljjz);
		for ($i=0;$i<count($list);$i++){
			if ($list[$i+1]['code']!=$list[$i]['code'])continue;
			$ljjz['11'.$list[$i+1]['code']]=round(($list[$i+1]['ljjz']-$list[$i]['ljjz'])/$list[$i]['ljjz'],2)*100;
			$i++;
		}
		/*---------------------------------------*/
		//13
		$dd=date("w",strtotime("-1 day -13 year ")); 
		$i=-1;
		while ($dd<1||$dd>5){//是工作日
			$i++;
			$dd=date("w",strtotime("$i day -13 year "));
		}
		$i=-1+$i;
		$dd=date("Y-m-d",strtotime("$i day -13 year "));
		
		$list=M('jztable')->field('ljjz,code,time')->
		where("time='$dd' or time='$d'")->order('`code` asc, time asc')->select();
//		echo M('jztable')->_sql();
//		dump($ljjz);
		for ($i=0;$i<count($list);$i++){
			if ($list[$i+1]['code']!=$list[$i]['code'])continue;
			$ljjz['13'.$list[$i+1]['code']]=round(($list[$i+1]['ljjz']-$list[$i]['ljjz'])/$list[$i]['ljjz'],2)*100;
			$i++;
		}
		/*---------------------------------------*/
//		select *   from   (select *   from jj_jztable order by time asc ) as a group by code
		$list=M('jztable')->query("select *   from   (select *   from jj_jztable order by time asc ) as a group by code");
		for ($i=0;$i<count($list);$i++){ 
		//$date=floor((time()-strtotime($list[$i]['time']))/86400);
		$y=floor((time()-strtotime($list[$i]['time']))/(86400*365));
		$m=floor((time()-strtotime($list[$i]['time']))%(86400*365)/(86400*30));
		$ljjz['cl'.$list[$i]['code']]="成立".$y.'年'.$m."个月";
		}
//		dump($list);
//		dump($ljjz);
		/*
		end计算年利率
		select ljjz,code,time from `jj_jztable` where time='2016-11-18' or time='2017-11-20' order by code
		 */
//		echo M('msck')->_sql();die;
		
//		$syList=M('msck')->where("`show`>=0 and time='".date("Y-m-d") ."'")->order('`show` asc,id asc')->select();
		   //insert into jj_msck(id,time,code,name,qk,`desc`,mbm,`show`,who,mb,money,today,dq,class) select 'NULL' as id,'2017-11-06' as time,code,name,qk,`desc`,mbm,`show`,who,mb,money,today,dq,class  from jj_msck where time='2017-11-03';
	 //update `jj_msck` set today=dq where time='2017-11-06';
	 $mairuzong=array();
	 $todayzong=array();
	 $todayzong2=array();
	 for ($i=0;$i<count($syList);$i++){
			if (!S('gszf'.$syList[$i]['code'])){
				$imgPath = "http://j4.dfcfw.com/charts/pic6/".$syList[$i]['code'].".png?v=";
				$gjPhone = new \Home\Common\Util\gjPhone($imgPath);
				//进行颜色分离
				$gjPhone->getHec();
				//画出横向数据
				$Data=$gjPhone->magHorData2();
				if(date( "H")<15)
				S('gszf'.$syList[$i]['code'],$Data,60*3);//60是60秒  60*60*12是12小时
				else
				S('gszf'.$syList[$i]['code'],$Data,60*60*12);//60是60秒  60*60*12是12小时
			}
			$syList[$i]['gszf']=S('gszf'.$syList[$i]['code']);;
			$jy=0;
			if ($syList[$i]['gszf']+$syList[$i]['rzzl']>2){//昨天+今天的利率超过2
				$jy=-0.5;
			}else if($syList[$i]['gszf']>2){//今天的利率超过2
				$jy=-0.5;
			}else if ($syList[$i]['gszf']+$syList[$i]['rzzl']>1.5){//昨天+今天的利率超过1.5
				$jy=-0.3;
			}else if($syList[$i]['gszf']>1.5){//今天的利率超过1.5
				$jy=-0.3;
			}else if ($syList[$i]['gszf']+$syList[$i]['rzzl']<-1.5){//昨天+今天的利率超过-1.5
				$jy=0.3;
			}else if($syList[$i]['gszf']<-1.5){//今天的利率超过-1.5
				$jy=0.3;
			}else if ($syList[$i]['gszf']+$syList[$i]['rzzl']<-2){//昨天+今天的利率超过-2
				$jy=0.5;
			}else if($syList[$i]['gszf']<-2){//今天的利率超过-2
				$jy=0.5;
			}
			
			$who=explode(',',$syList[$i]['who']);;
			$today=explode(',',$syList[$i]['today']);;
			$money=explode(',',$syList[$i]['money']);;
			for ($j=0;$j<count($today);$j++){
				if ($today[$j]>0)
				$todayzong[$who[$j]]+=$today[$j];
				else
				$todayzong2[$who[$j]]+=$today[$j];
			}
			for ($j=0;$j<count($money);$j++){
				$mairuzong[$who[$j]]+=$money[$j];
				$money[$j]=$money[$j]*$jy;
			}
			$syList[$i]['jy']=implode(',',$money);
			/*
		end计算年利率
		select ljjz,code,time from `jj_jztable` where time='2016-11-18' or time='2017-11-20' order by code
		 */
			$syList[$i]['nll1']=$ljjz['1'.$syList[$i]['code']];
			$syList[$i]['nll3']=$ljjz['3'.$syList[$i]['code']];
			$syList[$i]['nll5']=$ljjz['5'.$syList[$i]['code']];
			$syList[$i]['nll7']=$ljjz['7'.$syList[$i]['code']];
			$syList[$i]['nll9']=$ljjz['9'.$syList[$i]['code']];
			$syList[$i]['nll11']=$ljjz['11'.$syList[$i]['code']];
			$syList[$i]['nll13']=$ljjz['13'.$syList[$i]['code']];
			$syList[$i]['cl']=$ljjz['cl'.$syList[$i]['code']];
		} 
			$mairuzong=implode(',',$mairuzong);
			$todayzong2=implode(',',$todayzong2);
			$todayzong=implode(',',$todayzong);
		//排序
//		dump($syList);
//		$syList=$this->quickSort($syList,'gszf');
		$this->assign('syList',$syList); 
		$this->assign('todayzong',$todayzong); 
		$this->assign('todayzong2',$todayzong2); 
		$this->assign('mairuzong',$mairuzong); 
		 
		$this->display();
		
	}
	/*
净值估算,获取当前最新估值，通过图片解析
参数code
	*/
	public function imagesb(){  
		$code=I('request.code');; 
		// $t=new \Home\Common\Util\gjPhone();
		$imgPath = "http://j4.dfcfw.com/charts/pic6/".$code.".png?v=";
		$gjPhone = new \Home\Common\Util\gjPhone($imgPath);
		//进行颜色分离
		$gjPhone->getHec();
		//画出横向数据
		echo $horData = $gjPhone->magHorData2();
	}
}