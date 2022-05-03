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
	}
	public function addfirst(){
		$ok_time=I('request.ok_time');
		$code=I('request.code');
		$user_id=I('request.user_id');

			$todayjj=M('jztable')->where("code=$code and time='$ok_time'")->select(); //今天的增长率

				$ok_fene=round((300000*(1-0.0015))/$todayjj[0]['ljjz'],2); 		
				$zongfen=$ok_fene;
				$sxf=300000*0.0015;
				$is_use=0;$fen2=$ok_fene;

 $data=array('type'=>1,'code'=>$code,'uc_id'=>$user_id,'zong_fene'=>$zongfen,'ok_time'=>$ok_time,'jy_time'=>$ok_time,'sxf'=>$sxf,'ok_amount'=>round((300000*(1-0.0015))),'ok_jz'=>$todayjj[0]['ljjz'],'fen2'=>$fen2,'ok_fene'=>$ok_fene);
				$id=M('jiaoyijilu')->add($data);//echo M('jiaoyijilu')->_sql();
 				
	}
	public function del_transaction(){
		$id=I('request.id');
		if (!empty($id))
		M('transaction')->where('id='.id)->delete();
		$this->success("操作成功!!!",U('Home/index/add_transaction'));
	} 
	/*
	买入界面
	*/
	public function zichandetail(){
		$code=I('request.code'); 
		$user_id=I('request.user_id');//$_SESSION['user_id'];
		//找到上一条数据
		$desclist=M('jiaoyijilu')->where("code=$code and uc_id=$user_id")->order('jy_time desc')->limit(1)->select();
		if (empty($desclist)) {//第一次没有数据
			$day1=M('jztable')->where("code=$code ")->order('time asc')->limit(1)->select(); 
			$date=$day1[0]['time'];
			$todayjj=M('jztable')->where("code=$code and time='$date'")->select();//今天的增长率
		}else{
			$codel=M('code')->where("code=$code ")->select();//
			// if(empty($_POST['type'])){
			$date=date('Y-m-d',strtotime("+1 day",strtotime($desclist[0]['jy_time'])));

			$todayjj=M('jztable')->where("code=$code and time='$date'")->select(); //今天的增长率
			while (empty($todayjj)){ 
				$date=date('Y-m-d',strtotime("+1 day",strtotime($date)));
				// echo strtotime($date)."-----".strtotime("now").'<br>';
				if(strtotime($date)>strtotime("now")){break;}
				$todayjj=M('jztable')->where("code=$code and time='$date'")->select();//今天的增长率
			} 
		}
		// echo M('jztable')->_sql();
		// dump($todayjj);
		if(empty($_POST['type'])){
			$rand=rand();
			$_SESSION['rand']=$rand;
			$this->assign('rand',$rand); 
		}
		//-------------------------------------------------------------------------------------------------- 
				$zongfe=0;//总份额
				// echo $_GET['code'].'---'.$_POST['code'];
		if ($_POST['type']){//dump($_POST);
			if($_SESSION['rand']!=$_POST['rand']&$_GET['code']!=$_POST['code']){
				$this->error("重复提交");;
			}
			$rand=rand();
			$_SESSION['rand']=$rand;
			if ($_POST['type']==1) {
				$ok_amount=$_POST['ok_amount'];
				$ok_fene=round(($_POST['ok_amount']*(1-0.0015))/$todayjj[0]['ljjz'],2); 		
				$zongfen=$desclist[0]['zong_fene']+$ok_fene;
				$sxf=$_POST['ok_amount']*0.0015;
				$is_use=0;$fen2=$ok_fene;
			}else if($_POST['type']==2){
				$ok_fene=$_POST['ok_fene'];		
				$fen2=0;
				$zongfen=$desclist[0]['zong_fene']-$ok_fene;
				if ($zongfen<=0) { 
					$this->error("卖出超出了");
				}
				$zonge=round($ok_fene*$todayjj[0]['ljjz'],2);//总额
				$sxf=$zonge*0.005;//手续费
				//找到未卖成的记录
				$weimaichu=M('jiaoyijilu')->where("code=$code and uc_id=$user_id and type=1 and is_use<=1")->order('jy_time asc')->select();
				// echo M('jiaoyijilu')->_sql();
				$maichufen=$ok_fene;
				$shouyi=0;
				foreach ($weimaichu as $key => $value) {
					if($maichufen<=$value['fen2']){ //一条记录够抵上卖出
						$data['fen2']=$value['fen2']-$maichufen;
						if($maichufen==$value['fen2']) //==卖出
							$data['is_use']=2; 
						else//卖出有余
							$data['is_use']=1;// echo "2222";
						M('jiaoyijilu')->where("id=".$value['id'])->save($data);//修改被卖出的那天的记录
						// echo ($todayjj[0]['ljjz']-$value['ok_jz']).'----'.$maichufen.'++++'.$shouyi;
						$shouyi+=$maichufen*($todayjj[0]['ljjz']-$value['ok_jz'])*(1-0.005);
						$maichufen=0;break;
					}else{ //一条记录不够抵上卖出
						$maichufen-=$value['fen2'];
						$data['fen2']=0;
						$data['is_use']=2; //卖出全部
						M('jiaoyijilu')->where("id=".$value['id'])->save($data);//修改被卖出的那天的记录
						$shouyi+=$maichufen*($todayjj[0]['ljjz']-$value['ok_jz'])*(1-0.005);
					}
				}  
				$ok_amount=$zonge-$sxf; 
			}  
				$data=array('type'=>$_POST['type'],'code'=>$code,'uc_id'=>$user_id,'zong_fene'=>$zongfen,'ok_time'=>$_POST['jy_time'],'jy_time'=>$_POST['jy_time'],'sxf'=>$sxf,'ok_amount'=>$ok_amount,'ok_jz'=>$todayjj[0]['ljjz'],'fen2'=>$fen2,'ok_fene'=>$ok_fene,'shouyi'=>$shouyi);
				$id=M('jiaoyijilu')->add($data);//echo M('jiaoyijilu')->_sql();
 				if ($id){ 
					$this->success("插入成功");		
 				}else{
					$this->error("插入失败");
				}  
		} 
		// echo I('request.jy_time');
		$this->assign('date',$date);
		$this->assign('rzzl',$todayjj[0]['rzzl']);
		$this->assign('codename',$codel[0]['name']);  

		//----------------------------------------------------------------------------------------------
		$jztables=M('jiaoyijilu')->where("code=$code and ok_fene >0 and  uc_id=$user_id and jy_time<'".($date)."' ")->order('jy_time desc')->select();
		// dump($jztables); dump($desclist);
		$current_jine=$jztables[0]['zong_fene']*$jztables[0]['ok_jz'];//当前金额
		// }
		//持有收益=(买入时份额)*(现在的累计净值-买入时累计净值)-买入手续费
		$chiyoushouyi=0;
		//持有收益率=总持有收益/总买入金额(买入时金额+买入手续费)
		$zongbenjin=0; 
	    $leijiyingkui=0;//累计盈亏
	    // $daoxu=1;  
	    // $zhouqijiesu=1;//0为最后一个周期结束
	    $zongfen2=0;
		foreach ($jztables as $key => $value) {
			if ($value['type']==1) {
				$chiyoushouyi+=$value['fen2']*($desclist[0]['ok_jz']-$value['ok_jz'])-$value['sxf'];//当前份额(当前净值-买入时净值)-手续费 
				// echo $chiyoushouyi.'---'.$value['fen2'].'---'.$value['ok_jz'].'--'.$desclist[0]['ok_jz'].'--'.$value['sxf'].'<br>';
				$zongbenjin+=$value['fen2']*$value['ok_jz']/(1-0.0015);//
				$zongfen2+=$value['fen2'];
			} 
			 if ($value['type']==2) {
			 	 $leijiyingkui+=$value['shouyi']; 
			 }  
		} 
			// echo $current_jine.'---'.round($zongbenjin,2);
		$chiyoushouyilv=round($chiyoushouyi/$zongbenjin,4)*100;
		//找到上一条数据，修改
		$data=array('current_jine'=>round($zongfen2*$jztables[0]['ok_jz'],2),'zongbenjin'=>round($zongbenjin,2),'chiyoushouyi'=>round($chiyoushouyi,2),'chiyoushouyilv'=>$chiyoushouyilv,'leijiyingkui'=>round(($leijiyingkui+$chiyoushouyi),2));
		if(!empty($desclist))
		$id=M('jiaoyijilu')->where('id='.$desclist[0]['id'])->save($data); 
		
		// echo $lasttime.'<br>';
		echo '当前金额:'.round($zongfen2*$jztables[0]['ok_jz'],2).'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;本金:'.round($zongbenjin,2).'<br>';//本金+收益
		echo '持有收益:'.round($chiyoushouyi,2).'<br>';
		echo '持有收益率:'.$chiyoushouyilv.'%<br>';
		echo '累计盈亏:'.round(($leijiyingkui+$chiyoushouyi),2).'<br>'; 

		// $this->assign('benjin',round($zongbenjin,2));
		// $this->assign('chiyoushouyilv',round($chiyoushouyilv,2));

	//-----------------------------------------业绩走势-------------------------------------------

		$year=date('Y-m-d',strtotime("-1 year",strtotime($date)));
		$where="`code` ='$code' and ";
		$where.="`time` between '$year' and '$date'"; 
		// die();
		$new2 =M('jztable')->where( $where )->order('time desc')->select(); 
		// echo M('jztable')->_sql().'<br>';
		$v=0;// dump($new2);
		$chao10=false;
		$chao5=false;
		// $chao=$todayjj[0]['rzzl'];
		$s2="["; 
		for ($i=count($new2)-1;$i>=0;$i--){
			$brr[] = $v;
			$day[] =$new2[$i]['time'];
			if ($i!=count($new2)-1)$s2.=",";
			 $s2.="[Date.UTC(".gmdate('Y,m,d', (strtotime($new2[$i]['time'])-30*24*3600))."),$v]";
			 $v+=$new2[$i]['rzzl'];
		} 
		for ($i=0; $i <66 ; $i++) {  

			// if($i>=66){
			   $chao=($todayjj[0]['ljjz']-$new2[$i]['ljjz'])/$new2[$i]['ljjz'];
	// echo '---'.$todayjj[0]['ljjz'].'------v'.$new2[$i]['ljjz'].'--'.$new2[$i]['time'].'<br>';

				if($chao>0.05&&$i<22)$chao5=true;//做t,短期涨10个点
				if($chao>0.1)$chao10=true;
			// }
		}
		$s2.="]";
		$info=$s2;  
		// dump($chao5);
		// dump($chao10);
		$maichu=0;;//echo $zongbenjin;
		if($zongbenjin>700000){
			if($chiyoushouyilv>30){$maichu=15000/$todayjj[0]['ljjz'];}
			else if($chiyoushouyilv>20){$maichu=10000/$todayjj[0]['ljjz'];}
			else if($chiyoushouyilv>10){$maichu=5000/$todayjj[0]['ljjz'];} 
			else if($chiyoushouyilv>5){$maichu=3000/$todayjj[0]['ljjz'];} 
			else if($chao10){$maichu=2000/$todayjj[0]['ljjz'];}
			else if($chao5){$maichu=1000/$todayjj[0]['ljjz'];}
		}
		else if($zongbenjin>500000 ){
			if($chiyoushouyilv>40){$maichu=15000/$todayjj[0]['ljjz'];}
			else if($chiyoushouyilv>30){$maichu=10000/$todayjj[0]['ljjz'];}
			else if($chiyoushouyilv>20){$maichu=5000/$todayjj[0]['ljjz'];}
			else if($chiyoushouyilv>10){$maichu=1500/$todayjj[0]['ljjz'];} 
			else if($chao10){ $maichu=1000/$todayjj[0]['ljjz'];} 
		}
		else if($zongbenjin>400000 ){
			if($chiyoushouyilv>50){$maichu=15000/$todayjj[0]['ljjz'];}
			else if($chiyoushouyilv>40){$maichu=10000/$todayjj[0]['ljjz'];}
			else if($chiyoushouyilv>30){$maichu=5000/$todayjj[0]['ljjz'];}
			else if($chiyoushouyilv>25){$maichu=3000/$todayjj[0]['ljjz'];}  
			else if($chiyoushouyilv>20){$maichu=1200/$todayjj[0]['ljjz'];}  
		}
		else if($zongbenjin>300000 ){
			if($chiyoushouyilv>70){$maichu=15000/$todayjj[0]['ljjz'];}
			else if($chiyoushouyilv>50){$maichu=10000/$todayjj[0]['ljjz'];}
			else if($chiyoushouyilv>45){$maichu=5000/$todayjj[0]['ljjz'];}
			else if($chiyoushouyilv>40){$maichu=3000/$todayjj[0]['ljjz'];}
			else if($chiyoushouyilv>35){$maichu=1500/$todayjj[0]['ljjz'];}    
		}
		else if($zongbenjin>250000 ){
			if($chiyoushouyilv>100){$maichu=15000/$todayjj[0]['ljjz'];}
			else if($chiyoushouyilv>70){$maichu=10000/$todayjj[0]['ljjz'];}
			else if($chiyoushouyilv>50){$maichu=5000/$todayjj[0]['ljjz'];}
			else if($chiyoushouyilv>45){$maichu=3000/$todayjj[0]['ljjz'];}
			else if($chiyoushouyilv>40){$maichu=2000/$todayjj[0]['ljjz'];} 
		}
		else if($zongbenjin>200000 ){
			if($chiyoushouyilv>150){$maichu=15000/$todayjj[0]['ljjz'];}
			else if($chiyoushouyilv>100){$maichu=10000/$todayjj[0]['ljjz'];}
			else if($chiyoushouyilv>70){$maichu=5000/$todayjj[0]['ljjz'];}
			else if($chiyoushouyilv>60){$maichu=3000/$todayjj[0]['ljjz'];}
			else if($chiyoushouyilv>55){$maichu=2000/$todayjj[0]['ljjz'];}  
		}
		else if($zongbenjin>150000 ){
			if($chiyoushouyilv>150){$maichu=15000/$todayjj[0]['ljjz'];}
			else if($chiyoushouyilv>100){$maichu=10000/$todayjj[0]['ljjz'];}
			else if($chiyoushouyilv>90){$maichu=5000/$todayjj[0]['ljjz'];}
			else if($chiyoushouyilv>80){$maichu=3000/$todayjj[0]['ljjz'];}
			else if($chiyoushouyilv>75){$maichu=2000/$todayjj[0]['ljjz'];}  
		}
		else if($zongbenjin>100000 ){
			if($chiyoushouyilv>200){$maichu=15000/$todayjj[0]['ljjz'];}
			else if($chiyoushouyilv>150){$maichu=12000/$todayjj[0]['ljjz'];}
			else if($chiyoushouyilv>130){$maichu=8000/$todayjj[0]['ljjz'];} 
			else if($chiyoushouyilv>100){$maichu=5000/$todayjj[0]['ljjz'];} 
		}
		else if($zongbenjin>50000 ){
			if($chiyoushouyilv>200){$maichu=10000/$todayjj[0]['ljjz'];}
			else if($chiyoushouyilv>180){$maichu=5000/$todayjj[0]['ljjz'];} 
			else if($chiyoushouyilv>150){$maichu=3000/$todayjj[0]['ljjz'];} 
		}        
		$this->assign('info',$info);
		$this->assign('maichu',round($maichu,2)); 
 
		// $width=$limit*10;
		// $this->assign('width',$width);

		// $this->assign('container_list',$container);
		// $this->assign('width',3660);

		$this->assign('jiaoyijilulist',$jztables);
		if(I('request.zd')==1)
				$this->display('zichandetail2'); 
		else
				$this->display(); 
	} 
	/*
		
	*/
	public function show(){
		$code=I('request.code'); 
		$user_id=I('request.user_id');//$_SESSION['user_id'];

		//找到未卖成的记录
		$weimaichu=M('jiaoyijilu')->where("code=$code and uc_id=$user_id")->order('jy_time asc')->select();
// 		echo "<table>";//dump($weimaichu);die();
// echo "<td>时间</td><td>总本金</td> 
	// <td>持有收益</td>
	// <td>收益率</td> 
	// <td>累盈亏</td>"; 
		foreach ($weimaichu as $key => $value) {
// 			echo "<tr>";
// 			// dump($value);
// // echo "			$value['chiyoushouyi']";
// 			echo "<td>".$value['ok_time']."&nbsp;&nbsp;</td> ";
// 			echo "<td>".$value['chiyoushouyi']."</td> ";
// 			echo "<td>".$value['zongbenjin']."</td> ";
// 			echo "<td>".$value['chiyoushouyilv']."</td> ";
// 			echo "<td>".$value['leijiyingkui']."</td> ";
// 			echo "</tr>";
			echo "".$value['ok_time']."&nbsp;&nbsp;";
			// echo "持有收益".$value['chiyoushouyi']."</td> ";
			echo "总本金".round($value['zongbenjin']/10000,1)."万,";
			echo "收益率".$value['chiyoushouyilv']."%,";
			echo "累计收益".round($value['leijiyingkui']/10000,1)."万<br> ";
		}
		// echo "</table>";
 
		
	} 

}