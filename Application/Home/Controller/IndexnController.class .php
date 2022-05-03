<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
//	public function index(){
//		$this->display(); 
//	}
//	public function lljz(){
//		$this->display(); 
//	}

	 function __construct(){ 
        parent::__construct();
		session_start();  
		if (empty($_SESSION['user_id']))$_SESSION['user_id']=1;
		$this->assign('user',$_SESSION['user_id']); 
		$this->assign('time',$_SESSION['today']);
	}
	public function testexec(){
    $json = '{"a":1,"b":2,"c":3,"d":4,"e":5}';
    $json2 = '{"3a":3,"b":2,"c":3,"d":4,"e":5}';

   dump(json_decode($json));
   dump(json_decode($json2));
   dump(json_decode($json, true));
die;
		$command="c:\email.bat";
		for ($i=0;$i<10;$i++){
			
		echo '1';
		 $result= exec("echo aaa"); 
		if ($result=='aaa') 
		echo '2<br>';
		}
	}
	public function del_transaction(){
		$id=I('request.id');
		if (!empty($id))
		M('transaction')->where('id='.id)->delete();
		$this->success("操作成功!!!",U('Home/index/add_transaction'));
	}
	public function add_transaction(){
		$code=I('request.code'); 
		if(!empty($code))
		$where.=' and code='.$code;
		$_GET['user_id']=$_SESSION['user_id'];
		if ($_GET['type']){
			$id=M('transaction')->add($_GET);
			if ($id){
				$this->success("插入成功");				
			}else{
				$this->error("插入失败");
			} 
			
		}
		$userid=$_SESSION['user_id'];
		$list=M('user_code')->alias('a')
		->join('left join jj_code as b on b.code=a.code')->
		where("a.user_id=$userid and selected=1")->order('attention desc')->select();
		$this->assign('list',$list);
		
		$list=M('transaction')->where("user_id=$userid $where")->order('code ,time ')->select();
//		echo M('transaction')->_sql();
		$this->assign('list2',$list);
		
		$this->display(); 
	} 
	/*
		返回定投列表，是假数据，每日100，没有真实存入数据库
	*/
	public function dt(){
		$t=new \Home\Common\Util\Transaction();
		$t->getMoniList(8,'210009',"2012-08-13 12:00:00","2012-08-14 12:00:00");
		
		
	}
	/*
	mask里面复制前一天的
	*/
	public function ajaxfztoday(){
 		$da = date("w");
		if( $da == "1" ){  
			$d=date("Y-m-d",strtotime("-3 day"));
		}else
			$d=date("Y-m-d",strtotime("-1 day"));
	 	$msck = D('msck');
		$msck->execute("insert into jj_msck(id,time,code,name,qk,`desc`,mbm,`show`,who,mb,money,today,dq,class) select 'NULL' as id,'".date("Y-m-d")."' as time,code,name,qk,`desc`,mbm,`show`,who,mb,money,today,dq,class  from jj_msck where time='$d'");
 
       	$this->success("操作成功",U('home/report/msck'));
	}
	public function ajaxjia(){
		 $syList=M('msck')->alias('a')->field('a.*,b.rzzl')->
		join("left join jj_jztable as b on b.code=a.code and b.time='".date("Y-m-d") ."'")->
		where("`show`>=0 and a.time='".date("Y-m-d") ."' ")->order('`show` asc,a.id asc')->select(); 
		for ($i=0;$i<count($syList);$i++){ 
			$money=explode(',',$syList[$i]['money']);;
			$today=explode(',',$syList[$i]['today']);;
			for ($j=0;$j<count($today);$j++){
				$money[$j]=$money[$j]+$today[$j];
			}
			$m['money']=implode(',',$money);
			M('msck')->where('id='.$syList[$i]['id'])->save($m);
		}
//		$d['today']=0;
//		M('msck')->where("`show`>=0 and a.time='".date("Y-m-d")."' ")->save($d);
		M('msck')->execute("update `jj_msck` set today=dq where time='".date("Y-m-d")."'");
       	$this->success("操作成功",U('home/report/msck'));
	}
	public function ajaxmsck(){ 
		$value=trim(I('request.value'));
		$name=I('request.name');
		$id=I('request.id');
		$data[$name]=$value; 
		M('msck')->where('id='.$id)->save($data);
 		$da = date("w");
		if( $da == "1" ){  
			$d=date("Y-m-d",strtotime("-3 day"));
		}else
			$d=date("Y-m-d",strtotime("-1 day"));
		if ($name=='today'){
			$m=M('msck')->where('id='.$id)->find();
			if (empty($value)){
				M('transaction')->where("code= ".$m['code'] ."  and time='".date("Y-m-d") ."'")->delete();
				return ;
			}
			$who=explode(',',$m['who']);
			$v=explode(',',str_replace('，',',',str_replace('',' ',$value)));
			$jztable=M('jztable')->where("code= ".$m['code'] ."  and time='$d'")->find(); 
			for ($i=0;$i<count($who);$i++){
				//修改交易表
				$transaction=M('transaction')->where("code= ".$m['code'] ." and user_id= $who[$i]  and time='".date("Y-m-d") ."'")->find();
				$d['money']=$v[$i] ;
				$d['type']=1;
				if (empty($transaction)){ 
					$d['code']=$m['code'];
					$d['user_id']=$who[$i];
					$d['time']=date("Y-m-d") ;
					M('transaction')->add($d);
				}else{
					M('transaction')->where("code= ".$m['code'] ." and user_id= $who[$i]  and time='".date("Y-m-d") ."'")->save($d);
				}  
				//修改买时查看份额
				$fen[$i]=round($v[$i]/$jztable['dwjz'],2);
			}  
			echo $msck['fen']=implode(',',$fen);
				M('msck')->where('id='.$id)->save($msck);
		}else if ($name=='fen'){
				//修改交易表
			$m=M('msck')->where('id='.$id)->find();
			if (empty($value)){
				M('transaction')->where("code= ".$m['code'] ."  and time='".date("Y-m-d") ."'")->delete();
				return ;
			}
			$who=explode(',',$m['who']);
			$v=explode(',',str_replace('，',',',str_replace('',' ',$value)));//（100）
			$jztable=M('jztable')->where("code= ".$m['code'] ."  and time='$d'")->find();
			for ($i=0;$i<count($who);$i++){
				$transaction=M('transaction')->where("code= ".$m['code'] ." and user_id= $who[$i]  and time='".date("Y-m-d") ."'")->find();
				$d['fen']=$v[$i] ;
				$d['type']= -1;
				if (empty($transaction)){ 
					$d['code']=$m['code'];
					$d['user_id']=$who[$i];
					$d['time']=date("Y-m-d") ;
					M('transaction')->add($d);
				}else{
					M('transaction')->where("code= ".$m['code'] ." and user_id= $who[$i]  and time='".date("Y-m-d") ."'")->save($d);
				} 
				//修改买时查看钱数
				$fen[$i]=round($v[$i]*$jztable['dwjz'],2);
			} 
				echo $msck['today']=implode(',',$fen);
				M('msck')->where('id='.$id)->save($msck);
		} 
		//		echo M('msck')->_sql(); 
	}
}