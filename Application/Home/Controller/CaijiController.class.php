<?php
namespace Home\Controller;
use Think\Controller;
class CaijiController extends Controller { 

	 function __construct(){ 
        parent::__construct();
		session_start();  
		if (empty($_SESSION['user_id']))$_SESSION['user_id']=1;
		$this->assign('user',$_SESSION['user_id']); 
		$this->assign('time',$_SESSION['today']);
	} /*
	爬虫更新数据库
	*/
	public function cj(){  
//		die;
		//http://fund.eastmoney.com/f10/F10DataApi.aspx?type=lsjz&code=540006&page=1&per=200
		//http://j4.dfcfw.com/charts/pic6/001387.png
		//http://j4.dfcfw.com/charts/pic6/210009.png
		//http://j4.dfcfw.com/charts/pic6/161725.png
		//http://j4.dfcfw.com/charts/pic6/540006.png?v=0.958939652735444
		//http://fund.eastmoney.com/540006.html
		//select id-6422+91,time from `jj_jztable` where code=210009
		$ar=array('002973' );//'519983'

		// $ar2=array('汇丰晋信大盘股票A','金鹰核心资源混合','博时黄金ETFI','鹏华国防','申万菱信中证军工指数分级',
		// 		   '华宝标普石油指数','招商中证白酒指数分级','长信量化先锋混合A','万家消费成长','招商中证煤炭等权指数分级',
		// 		   '南方中证高铁产业指数分级');
		
		$p=I('request.p');
		$id=I('request.id');
		$id2=I('request.id2'); 
		$codes=M('code')->where('id>='.$id2.' and id<='.$id)->select();
		echo M('code')->_sql();
  			// echo "http://fund.eastmoney.com/f10/F10DataApi.aspx?type=lsjz&code=$code&page=$p&per=200000";
//		dump($codes);die;
		foreach ($codes as $k=>$v){ 
			$code=$v['code']; 
			
//			$code='540006';
  			header('Content-Type:text/html; charset=utf-8');
  			   //一次只能倒叙的10个为一页，每次需要修改page
  			$html=file_get_contents("http://fund.eastmoney.com/f10/F10DataApi.aspx?type=lsjz&code=$code&page=$p&per=200000");//获取页面内容
  			$tmp="/<tr.*>(.*)<\/tr>/iUs"; 
// echo "http://fund.eastmoney.com/f10/F10DataApi.aspx?type=lsjz&code=$code&page=$p&per=200000";
			preg_match_all($tmp,$html,$macthes); 
				$times='';
				// dump($macthes);
			foreach($macthes[1] as $i=>$tr) 
			{  
				if ($i==0)continue;
				$tmp="/<td.*>(.*)<\/td>/iUs"; 
				preg_match_all($tmp,$tr,$td); 
				if ($td[1][4]=='封闭期')continue;
				if ($td[1][0]=='暂无数据!')break;
				// dump($td);
				$data['time']=$td[1][0];
				$data['rzzl']=$td[1][3]==''?0:str_replace('%','',$td[1][3]);
				$data['ljjz']=$td[1][2]==''?0:$td[1][2];
				$data['dwjz']=$td[1][1];
				$data['fh']=$td[1][6];
				$data['code']=$code;
				$arr[]=$data;
				$times.="'".$td[1][0]."',";//时间集合用于在数据库内查重
				unset($data);
			} 
			// echo $times;
			// dump($arr);
			if(count($arr)<=0)continue;
			//查找已经存在的
				$times=substr($times,0,strlen($times)-1);
				$jztable=M('jztable')->field('time')->where('code='.$code.' and time  in ('.$times.')')->select();
				 
				// dump($arr);
				// dump($jztable);
				echo M('jztable')->_sql();
			for ($i=0;$i<count($arr);$i++){	
				// if (count($jztable)>0&&$arr[$i]['time']==$jztable[0]['time'])
				
				//  dump($arr[$i]['time']);
				// $b=in_array("2022-04-07", $jztable);
				$b=true;
				foreach($jztable as  $jz){  // echo  dump($jz['time']);//'--'.$jz.'<br>';         
		           if($jz['time']==$arr[$i]['time']){
					echo   '跳出'.$arr[$i]['time'].'=='.$jz['time'].'<br>';//dump($arr[$i]); 
					$b=false; 
			           break;//已经存在的记录
			       } 
		        } 
		        if($b)
				$v=M('jztable')->add($arr[$i]); 
				// echo '+++'.in_array($arr[$i]['time'], $jztable).'======';
				// echo   '继续'.$arr[$i]['time'].'==<br>';//.$jztable[0]['time'].'<br>';//dump($arr[$i]); 
// 				echo M('jztable')->_sql();
//					dump($v);  
			}
//			print_r($arr);
			unset($arr);
			echo '结束id='.$v['id'].'####'.$code;
		}
			die;

	} 
	/*
		定时器，每隔30秒调用一次，调用爬虫接口
	*/
	function crontab(){  
		// session_start();  
		if (empty($_SESSION['flag']))$_SESSION['flag']=1;
		else $_SESSION['flag']++;

		if (empty($_SESSION['p']))$_SESSION['p']=1;
		else if($_SESSION['flag']>=15)$_SESSION['p']++;
		
		if (empty($_SESSION['id']))$_SESSION['id']=10;
		else if($_SESSION['flag']<15)$_SESSION['id']+=10;
		else if($_SESSION['flag']>=15)$_SESSION['id']=10;
		
		if (empty($_SESSION['id2']))$_SESSION['id2']=1;
		else if($_SESSION['flag']<15)$_SESSION['id2']+=10;
 		else if($_SESSION['flag']>=15)$_SESSION['id2']=1;

		if($_SESSION['flag']>=15)$_SESSION['flag']=1;
 // $_SESSION['flag']=1;

	// $_SESSION['id']=10;$_SESSION['id2']=1; $_SESSION['p']=1;
		dump($_SESSION);
		header('Content-Type:text/html; charset=utf-8');
  			   //一次只能倒叙的10个为一页，每次需要修改page
  			// echo $html=file_get_contents("info.txt");//获取页面内容
  			     // echo "http://124.223.181.223/home/caiji/cj/id/".$_SESSION['id']."/id2/".$_SESSION['id2']."/p/".$_SESSION['p'];die();
  			     $html=file_get_contents("http://124.223.181.223/home/caiji/cj/id/".$_SESSION['id']."/id2/".$_SESSION['id2']."/p/".$_SESSION['p']);//获取页面内容

	}
}