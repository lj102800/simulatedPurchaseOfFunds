<?php

namespace Home\Common\Util; 
class Transaction{
		public $i=3;
		public $mcll=0.005;//0.005 卖出利率
		public $mrll=0.0015 ;//0.0015 买入利率
		public $code=0;
//		public $begin='2017-08-08';
//		public $end='2017-09-08';
		public $sum=0;
		public $gain=0;
		public $mairu=0;
		public $maichu=0;
		public $drsy=0;
//		$sum2=0;//同一天多次购买
		public $sunfen=0;
		public $fen=0;
		public $maifen=0;
		public $sumdrsy=30;
		public $mairusxf=0;
		public $fen2=0;
	function g(){
		echo $this->i;
	}
	
	function updateSellFen($list){
		 for ($i=0;$i<count($list);$i++){
			if ($list[$i]['type']==1){//买入
//					if (!empty($list[$i+1])&&date('Y-m-d', strtotime($list[$i]['time']))==date('Y-m-d', strtotime($list[$i+1]['time']))){
//					 	$list[$i+1]['money']=$list[$i+1]['money']+$list[$i]['money'];
//						continue;
//					}
					$jz=M('jztable')->where(" code=$this->code  and time = '".date('Y-m-d',strtotime($list[$i]['time']." +0 day") )."' ")->find();
						/******修改买入份额********/ 
						for ($j=$i;;$j--){
							if (!empty($list[$j])&&date('Y-m-d', strtotime($list[$i]['time']))==date('Y-m-d', strtotime($list[$j]['time']))){
//								echo '('.$list[$j]['money'].'-'.$list[$j]['money']*$this->mrll.')/'.$jz['dwjz'].'='.round(round($list[$j]['money']-$list[$j]['money']*$this->mrll,2)/$jz['dwjz'],2); 

								$fen['fen']=round(round($list[$j]['money']-$list[$j]['money']*$this->mrll,2)/$jz['dwjz'],2);; 
								M('transaction')->where(" id=".$list[$j]['id'])->save($fen);
							} else{
								break;
							}
						}
						/******修改买入份额********/
					$t1 = strtotime($list[$i]['time']); 
					if (empty($jz)&&date('Y-m-d', time())==date('Y-m-d', $t1)){//当前天买的，并且没有利率呢
						continue;
					} 
					    $rzzl=$jz['rzzl']*$this->sum/100.0;
						//$this->drsy.="round(".$jz['rzzl']."*$this->sum/100.0,2)";
						$this->sum+=$rzzl;
						$this->sum2=round($list[$i]['money']-$list[$i]['money']*$this->mrll,2);
						
						$sy['mairu']=$list[$i]['money'];
					
						$this->mairu=0; 
					 	$this->gain+=$rzzl;
						$sy['gain']=round($this->gain,2); ;
//						echo $this->sum2;
						$sxf=round($this->sum2*$this->mrll,2);
						$sy['sxf']=$sxf;
						$this->drsy+=round($rzzl-$sxf,2);;
						$sy['rzzl']=$jz['rzzl']; 
						$sy['drsy']=round($this->drsy,2); 
						$this->maifen=round(round($list[$i]['money']-$sxf,2)/$jz['dwjz'],2);
						$sy['maifen']=$this->maifen;
						$this->fen+=$this->maifen;
						$this->maifen=0;
						$sy['fen']=$this->fen;//round(round($list[$i]['money']+$this->drsy,2)/$jz['dwjz'],2);
						$this->sum+=$this->sum2;//同一天多次购买
						$this->sum=round($this->sum,2);
						$sy['sum']=round($this->sum,2);//$this->fen/$jz['dwjz'];
						$sy['gainlv']= round($sy['gain']/($sy['sum']-$sy['gain']),2)*100;
						$sy['time']=$jz['time'];
						$syList[]=$sy;	
						$sy['drsy']=$this->drsy;//round($this->drsy,2);	 
					 	$this->sumdrsy+=round($this->drsy,2);
						$this->drsy=0;
						unset($sy);
						
						$this->sum2=0;
			}else{//卖出不考虑多次卖出这种了，否则和多次买入混在一块太乱了 
				$jz=M('jztable')->where(" code=$this->code  and time = '".date('Y-m-d',strtotime($list[$i]['time']." +0 day") )."' ")->find();
//				dump($jz);
			
				$t1 = strtotime($list[$i]['time']); 
				if (empty($jz)&&date('Y-m-d', time())==date('Y-m-d', $t1)){//当前天买的，并且没有利率呢
					continue;
				}
//echo "<br>";
 				$this->maichu=round($list[$i]['fen']*$jz['dwjz'],2);
						$sxf2=round($this->maichu*$this->mcll,2);
						$sy['sxf2']=$sxf2;
//						$sy['maifen']=$this->maifen;
						$sy['rzzl']=$jz['rzzl']; 
						$this->fen-=$list[$i]['fen'];
						$this->sum=round($this->fen*$jz['dwjz'],2);
						$sy['gain']=round($this->gain,2); 
						$sy['fen']=round($this->fen,2); 
						$sy['sum']=round($this->fen*$jz['dwjz'],2);
						$sy['gainlv']= round($sy['gain']/($sy['sum']-$sy['gain']),2)*100;
					  	$sy['maichu']=round($this->maichu-$sxf2,2);
						$sy['maichufen']=$list[$i]['fen'];
						$this->maichu=0;  
						$sy['time']=$jz['time'];
						$syList[]=$sy; 
						unset($sy);

			}
//			echo '<br>'.$list[$i]['time'].'-----'.$list[$i]['money'].'-----'.$this->sum=round($this->sum,2).'-----'.$this->gain; 
			if (count($list)>$i+1){//$i+1存在
					//购买之后的计算				
					//买和卖直接的时间段，买之后一天到卖当天3点前算当天的
					$jz=M('jztable')->where(" code=$this->code  and time between '".date('Y-m-d',strtotime($list[$i]['time']." +1 day")+9*3600)."' and 
					'".date('Y-m-d',strtotime($list[$i+1]['time']."-1 day")+9*3600)."'")->select();
//					echo M('jztable')->_sql();
//					dump($jz);
					for ($j=0;$j<count($jz);$j++){
 						$rzzl=$jz[$j]['rzzl']*$this->sum/100.0 ;
// 						echo $jz[$j]['rzzl'].'*'.$this->fen.'='.$jz[$j]['rzzl']*$this->fen/100.0.'<br>';
						$this->sum+=$rzzl;
						$this->sum=round($this->sum,2);
						$this->gain+=$rzzl;
						$this->drsy+=$rzzl;
						$sy['mairu']=$this->mairu ;
						
						 
						$sy['rzzl']=$jz[$j]['rzzl'];
 						$sy['drsy']=round($this->drsy,2);	 
						$this->sumdrsy+=round($this->drsy,2);
						$this->drsy=0;
						$sy['gain']=round($this->gain,2);;
						$sy['sum']=round($this->sum,2);
						$sy['gainlv']= round($sy['gain']/($sy['sum']-$sy['gain']),2)*100;
						$sy['time']=$jz[$j]['time'];
						$sy['fen']=round($this->fen,2);;
						$syList[]=$sy;
						unset($sy);
//						echo '<br>'.$jz[$j]['rzzl'].'*'.$this->sum/100.0.'aaaaaaaaaaaa'.$jz[$j]['rzzl']*$this->sum/100.0.'++++'.$rzzl.'=='.$this->gain."====".$jz[$j]['time'];
					}
				} 
			} 
	}
	/**
	 * 通过购买记录计算收益
	 *
	 * @param unknown_type $list
	 * @return unknown
	 */
	function getlist($list){ 
	for ($i=0;$i<count($list);$i++){echo 24;
			if ($list[$i]['type']==1){//买入
					if (!empty($list[$i+1])&&date('Y-m-d', strtotime($list[$i]['time']))==date('Y-m-d', strtotime($list[$i+1]['time']))){
					 	$list[$i+1]['money']=$list[$i+1]['money']+$list[$i]['money'];
						continue;
					}
					$jz=M('jztable')->where(" code=$this->code  and time = '".date('Y-m-d',strtotime($list[$i]['time']." +0 day") )."' ")->find();
					$t1 = strtotime($list[$i]['time']); 
					if (empty($jz)&&date('Y-m-d', time())==date('Y-m-d', $t1)){//当前天买的，并且没有利率呢
						continue;
					} 
					    $rzzl=$jz['rzzl']*$this->sum/100.0;
						//$this->drsy.="round(".$jz['rzzl']."*$this->sum/100.0,2)";
						$this->sum+=$rzzl;
						$this->sum2=round($list[$i]['money']-$list[$i]['money']*$this->mrll,2);
						
						$sy['mairu']=$list[$i]['money'];
					
						$this->mairu=0; 
					 	$this->gain+=$rzzl;
						$sy['gain']=round($this->gain,2); ;
//						echo $this->sum2;
						$sxf=round($this->sum2*$this->mrll,2);
						$sy['sxf']=$sxf;
						$this->drsy+=round($rzzl-$sxf,2);;
						$sy['rzzl']=$jz['rzzl']; 
						$sy['drsy']=round($this->drsy,2); 
						$this->maifen=round(round($list[$i]['money']-$sxf,2)/$jz['dwjz'],2);
						$sy['maifen']=$this->maifen;
						$this->fen+=$this->maifen;
						$this->maifen=0;
						$sy['fen']=$this->fen;//round(round($list[$i]['money']+$this->drsy,2)/$jz['dwjz'],2);
						$this->sum+=$this->sum2;//同一天多次购买
						$this->sum=round($this->sum,2);
						$sy['sum']=round($this->sum,2);//$this->fen/$jz['dwjz'];
						$sy['gainlv']= round($sy['gain']/($sy['sum']-$sy['gain']),2)*100;
						$sy['time']=$jz['time'];
						$syList[]=$sy;	
						$sy['drsy']=$this->drsy;//round($this->drsy,2);	 
					 	$this->sumdrsy+=round($this->drsy,2);
						$this->drsy=0;
						unset($sy);
						
						$this->sum2=0;
			}else{//卖出不考虑多次卖出这种了，否则和多次买入混在一块太乱了 
				$jz=M('jztable')->where(" code=$this->code  and time = '".date('Y-m-d',strtotime($list[$i]['time']." +0 day") )."' ")->find();
//				dump($jz);
			
				$t1 = strtotime($list[$i]['time']); 
				if (empty($jz)&&date('Y-m-d', time())==date('Y-m-d', $t1)){//当前天买的，并且没有利率呢
					continue;
				}
//echo "<br>";
 				$this->maichu=round($list[$i]['fen']*$jz['dwjz'],2);
						$sxf2=round($this->maichu*$this->mcll,2);
						$sy['sxf2']=$sxf2;
//						$sy['maifen']=$this->maifen;
						$sy['rzzl']=$jz['rzzl']; 
						$this->fen-=$list[$i]['fen'];
						$this->sum=round($this->fen*$jz['dwjz'],2);
						$sy['gain']=round($this->gain,2); 
						$sy['fen']=round($this->fen,2); 
						$sy['sum']=round($this->fen*$jz['dwjz'],2);
						$sy['gainlv']= round($sy['gain']/($sy['sum']-$sy['gain']),2)*100;
					  	$sy['maichu']=round($this->maichu-$sxf2,2);
						$sy['maichufen']=$list[$i]['fen'];
						$this->maichu=0;  
						$sy['time']=$jz['time'];
						$syList[]=$sy; 
						unset($sy);

			}
//			echo '<br>'.$list[$i]['time'].'-----'.$list[$i]['money'].'-----'.$this->sum=round($this->sum,2).'-----'.$this->gain; 
			if (count($list)>$i+1){//$i+1存在
					//购买之后的计算				
					//买和卖直接的时间段，买之后一天到卖当天3点前算当天的
					$jz=M('jztable')->where(" code=$this->code  and time between '".date('Y-m-d',strtotime($list[$i]['time']." +1 day")+9*3600)."' and 
					'".date('Y-m-d',strtotime($list[$i+1]['time']."-1 day")+9*3600)."'")->select();
//					echo M('jztable')->_sql();
//					dump($jz);
					for ($j=0;$j<count($jz);$j++){
 						$rzzl=$jz[$j]['rzzl']*$this->sum/100.0 ;
// 						echo $jz[$j]['rzzl'].'*'.$this->fen.'='.$jz[$j]['rzzl']*$this->fen/100.0.'<br>';
						$this->sum+=$rzzl;
						$this->sum=round($this->sum,2);
						$this->gain+=$rzzl;
						$this->drsy+=$rzzl;
						$sy['mairu']=$this->mairu ;
						
						 
						$sy['rzzl']=$jz[$j]['rzzl'];
 						$sy['drsy']=round($this->drsy,2);	 
						$this->sumdrsy+=round($this->drsy,2);
						$this->drsy=0;
						$sy['gain']=round($this->gain,2);;
						$sy['sum']=round($this->sum,2);
						$sy['gainlv']= round($sy['gain']/($sy['sum']-$sy['gain']),2)*100;
						$sy['time']=$jz[$j]['time'];
						$sy['fen']=round($this->fen,2);;
						$syList[]=$sy;
						unset($sy);
//						echo '<br>'.$jz[$j]['rzzl'].'*'.$this->sum/100.0.'aaaaaaaaaaaa'.$jz[$j]['rzzl']*$this->sum/100.0.'++++'.$rzzl.'=='.$this->gain."====".$jz[$j]['time'];
					}
				} 
			} 
			return $syList;
	}

//	/**
//	 * 修改是否使用过
//	 * 
//	 */
//	function updateUse($user,$code){  
//			/*******/
//			$mcList=M('transaction')->where("is_use!=1 and type=-1 and user_id=$user and code=$code")->order('time desc')->select();
//			for ($i=0;$i<count($mcList);$i++){ 
//				$mrList=M('transaction')->where("is_use!=1 and type=1 and user_id=$user and code=$code")->order('time asc')->select();
////				echo M('transaction')->_sql();
//				for ($j=0;$j<count($mrList);$j++){
//					if ($mcList[$i]['fen']-($mrList[$j]['fen']-$mrList[$j]['fen2'])>0){//卖出-买入后还有余
//						$c['is_use']=1;
//						$c['fen2']=$mrList[$j]['fen'];
//						M('transaction')->where('id='.$mrList[$j]['id'])->save($c);
//						$mcList[$i]['fen']=$mcList[$i]['fen']-($mrList[$j]['fen']-$mrList[$j]['fen2']);
//					}else if ($mcList[$i]['fen']-($mrList[$j]['fen']-$mrList[$j]['fen2'])<0){//卖出不够买入的 
//						$c['is_use']=2;
//						$c['fen2']=$mcList[$i]['fen'];
//						M('transaction')->where('id='.$mrList[$j]['id'])->save($c); 
//						break;
//					}else{ //卖出=买入
//						$c['is_use']=1;
//						M('transaction')->where('id='.$mrList[$j]['id'])->save($c);
//						break;
//					}
//				}
//				$c2['is_use']=1;
//				M('transaction')->where('id='.$mcList[$i]['id'])->save($c2);
//			} 
//	}
	/**
	 * 修改是否使用过
	 * 
	 */
	function updateUse2($user,$code){  
			/*******/
			$mcList=M('transaction')->where("is_use!=1 and type=-1 and user_id=$user and code=$code")->order('time asc')->select();
//			echo M('transaction')->_sql();
			for ($i=0;$i<count($mcList);$i++){ 
				$mrList=M('transaction')->where("is_use!=1 and type=1 and user_id=$user and code=$code")->order('time asc')->select();
				echo M('transaction')->_sql();
				$seD['code']=$code;
				for ($j=0;$j<count($mrList);$j++){ 
					if ($mcList[$i]['fen']-($mrList[$j]['fen']-$mrList[$j]['fen2'])>0){//卖出-买入后还有余
						$c['is_use']=1;
						$c['fen2']=$mrList[$j]['fen'];
						M('transaction')->where('id='.$mrList[$j]['id'])->save($c); 
						
						$seD['id_mr']=$mrList[$j]['id'];
						$seD['id_mc']=$mcList[$i]['id'];
						$seD['fen']=($mrList[$j]['fen']-$mrList[$j]['fen2']);
						$seD['count_day']=floor((strtotime($mcList[$i]['time'])-strtotime($mrList[$j]['time']))/86400);
						M('transaction_sell')->add($seD); 
						$mcList[$i]['fen']=$mcList[$i]['fen']-($mrList[$j]['fen']-$mrList[$j]['fen2']);
					}else if ($mcList[$i]['fen']-($mrList[$j]['fen']-$mrList[$j]['fen2'])<0){//卖出不够买入的 
						$c['is_use']=2;
						$c['fen2']=$mcList[$i]['fen']+$mrList[$j]['fen2'];
						M('transaction')->where('id='.$mrList[$j]['id'])->save($c);
						 
						$seD['id_mr']=$mrList[$j]['id'];
						$seD['id_mc']=$mcList[$i]['id'];
						$seD['fen']=$mcList[$i]['fen'];
						$seD['count_day']=floor((strtotime($mcList[$i]['time'])-strtotime($mrList[$j]['time']))/86400);
						M('transaction_sell')->add($seD);
						break;
					}else{ //卖出=买入
						$c['is_use']=1;
						$c['fen2']=$mrList[$j]['fen'];
						M('transaction')->where('id='.$mrList[$j]['id'])->save($c);
						
						$seD['id_mr']=$mrList[$j]['id'];
						$seD['id_mc']=$mcList[$i]['id'];
						$seD['fen']=$mrList[$j]['fen'];
						$seD['count_day']=floor((strtotime($mcList[$i]['time'])-strtotime($mrList[$j]['time']))/86400);
						M('transaction_sell')->add($seD); 
						break;
					}
				}
				unset($mrList);
				$c2['is_use']=1;
				M('transaction')->where('id='.$mcList[$i]['id'])->save($c2);
			} 
	}
	/**
	 * 通过购买记录计算收益
	 *
	 * @param unknown_type $list
	 * @return unknown
	 */
	function getZhouqi($user,$code,$begin,$end){    
		$money=0;
		$shouyi=0;
		$chiyje=0;
		$money1=0;
		$shouyi1=0;
 	 		$trans=M('transaction_sell')->alias('a')
 	 		->field('c.code,name,a.fen,DATE_FORMAT(c.time,\'%Y-%m-%d\') as start_time,DATE_FORMAT(d.time,\'%Y-%m-%d\') as end_time,  DATEDIFF(d.time,c.time) as zong_day')
 	 		->join('jj_transaction as c on c.id=a.id_mr')
 	 		->join('jj_transaction as d on d.id=a.id_mc')
 	 		->join('jj_code as b on b.code=c.code')
 	 		->where("c.type=1 and c.is_use!=0 and c.user_id=$user and c.code=$code and count_day>0 and c.time>='$begin' and d.time<='$end'")->order('a.id asc')->select(); 
// 	 		echo M('transaction')->_sql();
// 	 		$trans=array_merge($trans,$trans2);
			
 	 		for ($i=0;$i<count($trans);$i++){
 	 			$jz=M('jztable')->where("code=$code and time in ('".$trans[$i]['end_time']."' ,'".$trans[$i]['start_time']."')")->order('time desc')->select();
 	 			//$jz[1]['dwjz']买入$jz[0]['dwjz']卖出
// 	 			$trans[$i]['shouyi']=$trans[$i]['fen']."=".round($trans[$i]['fen']*$jz[0]['dwjz'],2);
 	 			$trans[$i]['shouyi']=round(round($trans[$i]['fen']*$jz[0]['dwjz'],2)-round($trans[$i]['fen']*$jz[1]['dwjz'],2)-round($trans[$i]['fen']*$jz[0]['dwjz']*($this->mcll),2)-round($trans[$i]['fen']*$jz[1]['dwjz']*($this->mrll),2),2);
 	 			$shouyi1+=$trans[$i]['shouyi'];
 	 			$trans[$i]['money']=round(round($trans[$i]['fen']*$jz[1]['dwjz'],2)+ round($trans[$i]['fen']*$jz[1]['dwjz'],2)*$this->mrll,2);
// 	 			$trans[$i]['chiyje']=round(round($trans[$i]['fen']*$jz[1]['dwjz'],2)+ round($trans[$i]['fen']*$jz[1]['dwjz'],2)*$this->mrll,2);
 	 			$money1+=$trans[$i]['money'];
 	 			$trans[$i]['rilv']=round($trans[$i]['shouyi']*100/$trans[$i]['money']/$trans[$i]['zong_day'],2);
 	 			$trans[$i]['yuelv']=round($trans[$i]['shouyi']*3000/$trans[$i]['money']/$trans[$i]['zong_day'],2);
 	 			$trans[$i]['nianlv']=round($trans[$i]['shouyi']*36500/$trans[$i]['money']/$trans[$i]['zong_day'],2);
// 	 			echo '<br>'.M('jztable')->_sql().'<br>';
 	 		}  
			$lastday=$end;
	 		$trans2=M('transaction')->alias('a')
 	 		->field("a.code,name,(`fen`-`fen2`) as fen,DATE_FORMAT(a.time,'%Y-%m-%d') as start_time,DATE_FORMAT('$lastday','%Y-%m-%d') as end_time,  DATEDIFF(now(),a.time) as zong_day")
 	 		->join('jj_code as b on b.code=a.code')
 	 		->where("is_use!=1 and a.type=1 and a.code=$code and a.user_id=$user and a.time between '$begin' and '$end'")->order('a.time asc')->select();
				
// 	 		echo '<br>'.M('transaction')->_sql().'<br>';
			$max=0;
 	 		for ($i=0;$i<count($trans2);$i++){
 	 			$jz[0]=M('jztable')->where("code=$code and time >= '".$trans2[$i]['start_time']."' ")->order('time asc')->find(); 
 	 			$jz[1]=M('jztable')->where("code=$code and time <='".$trans2[$i]['end_time']."' ")->order('time desc')->find(); 
 	 			//$jz[0]['dwjz'];买入$jz[1]['dwjz'];卖出
 	 			$trans2[$i]['shouyi']=round(round($trans2[$i]['fen']*$jz[1]['dwjz'],2) -round($trans2[$i]['fen']*$jz[0]['dwjz'],2)- round($trans2[$i]['fen']*$jz[0]['dwjz']*$this->mrll,2)  ,2);
 	 			$shouyi+=$trans2[$i]['shouyi'];
 	 			$trans2[$i]['chiyje']=round($trans2[$i]['fen']*$jz[1]['dwjz'],2);
				$chiyje+=$trans2[$i]['chiyje'];
 	 			$max=max($max,$chiyje);
 	 			$trans2[$i]['money']=round(round($trans2[$i]['fen']*$jz[0]['dwjz'],3)+ round($trans2[$i]['fen']*$jz[0]['dwjz']*$this->mrll,2),1);
 	 			$money+=$trans2[$i]['money'];
 	 			$trans2[$i]['start_time']=$jz[0]['time'];
 	 			$trans2[$i]['end_time']=$jz[1]['time'];
 	 			$trans2[$i]['rilv']=round($trans2[$i]['shouyi']*100/$trans2[$i]['money']/$trans2[$i]['zong_day'],2);
 	 			$trans2[$i]['yuelv']=round($trans2[$i]['shouyi']*3000/$trans2[$i]['money']/$trans2[$i]['zong_day'],2);
 	 			$trans2[$i]['nianlv']=round($trans2[$i]['shouyi']*36500/$trans2[$i]['money']/$trans2[$i]['zong_day'],2);
 	 		} 
 	 		$trans3=M('transaction')->alias('a')
 	 		->field("a.code,name,(`fen`-`fen2`) as fen,DATE_FORMAT(a.time,'%Y-%m-%d') as start_time,DATE_FORMAT('$lastday','%Y-%m-%d') as end_time,  DATEDIFF(now(),a.time) as zong_day")
 	 		->join('jj_code as b on b.code=a.code')
 	 		->where("a.type=3 and a.code=$code and a.user_id=$user and a.time between '$begin' and '$end'")->order('a.time asc')->select();
 	 		
 	 		for ($i=0;$i<count($trans3);$i++){
// 	 			$money+=$trans2[$i]['money'];
 	 		}
 	 		$t['max']=$max;
 	 		$t['zts']= (strtotime($trans2[count($trans2)-1]['end_time'])-strtotime($trans2[0]['start_time']))/86400 ;
// 	 		$t['zts']=floor((strtotime($trans2[count($trans2)-1]['end_time'])-strtotime($trans2[0]['start_time'])/86400));
 	 		$t['code']=$code;
 	 		$t['name']=$trans2[0]['name'];
 	 		$t['syList']=$trans;
 	 		$t['syList2']=$trans2;
 	 		$t['money']=$money;
 	 		$t['shouyi']=$shouyi;
 	 		$t['money1']=$money1;
 	 		$t['shouyi1']=$shouyi1;
 	 		$t['money2']=$money1+$money;
 	 		$t['shouyi2']=$shouyi1+$shouyi;
 	 		$t['chiyje']=$chiyje;
 	 		 return $t;
 	 		
// 	 		->join("jj_jztable as e on e.code=a.code and DATE_FORMAT(c.time,'%Y-%m-%d')=DATE_FORMAT(e.time,'%Y-%m-%d')")
 	 		
//	for ($i=0;$i<count($list);$i++){
//		
//			if ($list[$i]['type']==1){
//					if (!empty($list[$i+1])&&date('Y-m-d', strtotime($list[$i]['time']))==date('Y-m-d', strtotime($list[$i+1]['time']))){
//					 	$list[$i+1]['money']=$list[$i+1]['money']+$list[$i]['money'];
//						continue;
//					}
//					$jz=M('jztable')->where(" code=$this->code  and time = '".date('Y-m-d',strtotime($list[$i]['time']." +0 day") )."' ")->find();
//					$t1 = strtotime($list[$i]['time']); 
//					if (empty($jz)&&date('Y-m-d', time())==date('Y-m-d', $t1)){//当前天买的，并且没有利率呢
//						continue;
//					} 
//					    $rzzl=$jz['rzzl']*$this->sum/100.0;
//						//$this->drsy.="round(".$jz['rzzl']."*$this->sum/100.0,2)";
//						$this->sum+=$rzzl;
//						$this->sum2=round($list[$i]['money']-$list[$i]['money']*$this->mrll,2);
//						
//						$sy['mairu']=$list[$i]['money'];
//					
//						$this->mairu=0; 
//					 	$this->gain+=$rzzl;
//						$sy['gain']=round($this->gain,2); ;
////						echo $this->sum2;
//						$sxf=round($this->sum2*$this->mrll,2);
//						$sy['sxf']=$sxf;
//						$this->drsy+=round($rzzl-$sxf,2);;
//						$sy['rzzl']=$jz['rzzl']; 
//						$sy['drsy']=round($this->drsy,2); 
//						$this->maifen=round(round($list[$i]['money']-$sxf,2)/$jz['dwjz'],2);
//						$sy['maifen']=$this->maifen;
//						$this->fen+=$this->maifen;
//						$this->maifen=0;
//						$sy['fen']=$this->fen;//round(round($list[$i]['money']+$this->drsy,2)/$jz['dwjz'],2);
//						$this->sum+=$this->sum2;//同一天多次购买
//						$this->sum=round($this->sum,2);
//						$sy['sum']=round($this->sum,2);//$this->fen/$jz['dwjz'];
//						$sy['gainlv']= round($sy['gain']/($sy['sum']-$sy['gain']),2)*100;
//						$sy['time']=$jz['time'];
//						$syList[]=$sy;	
//						$sy['drsy']=$this->drsy;//round($this->drsy,2);	 
//					 	$this->sumdrsy+=round($this->drsy,2);
//						$this->drsy=0;
//						unset($sy);
//						
//						$this->sum2=0;
//			}else{//卖出不考虑多次卖出这种了，否则和多次买入混在一块太乱了 
//				$jz=M('jztable')->where(" code=$this->code  and time = '".date('Y-m-d',strtotime($list[$i]['time']." +0 day") )."' ")->find();
////				dump($jz);
//			
//				$t1 = strtotime($list[$i]['time']); 
//				if (empty($jz)&&date('Y-m-d', time())==date('Y-m-d', $t1)){//当前天买的，并且没有利率呢
//					continue;
//				}
////echo "<br>";
// 				$this->maichu=round($list[$i]['fen']*$jz['dwjz'],2);
//						$sxf2=round($this->maichu*$this->mcll,2);
//						$sy['sxf2']=$sxf2;
////						$sy['maifen']=$this->maifen;
//						$sy['rzzl']=$jz['rzzl']; 
//						$this->fen-=$list[$i]['fen'];
//						$this->sum=round($this->fen*$jz['dwjz'],2);
//						$sy['gain']=round($this->gain,2); 
//						$sy['fen']=round($this->fen,2); 
//						$sy['sum']=round($this->fen*$jz['dwjz'],2);
//						$sy['gainlv']= round($sy['gain']/($sy['sum']-$sy['gain']),2)*100;
//					  	$sy['maichu']=round($this->maichu-$sxf2,2);
//						$sy['maichufen']=$list[$i]['fen'];
//						$this->maichu=0;  
//						$sy['time']=$jz['time'];
//						$syList[]=$sy; 
//						unset($sy);
//						/***修改是否使用过****/
//						$sellList=M('jztable')->where('is_use!=1 and type=1')->select();
//						for ($i=0;$i<count($sellList);$i++){
//							$sellList[$i];
//						}
//						/***修改是否使用过****/
//
//			}
////			echo '<br>'.$list[$i]['time'].'-----'.$list[$i]['money'].'-----'.$this->sum=round($this->sum,2).'-----'.$this->gain; 
//			if (count($list)>$i+1){//$i+1存在
//					//购买之后的计算				
//					//买和卖直接的时间段，买之后一天到卖当天3点前算当天的
//					$jz=M('jztable')->where(" code=$this->code  and time between '".date('Y-m-d',strtotime($list[$i]['time']." +1 day")+9*3600)."' and 
//					'".date('Y-m-d',strtotime($list[$i+1]['time']."-1 day")+9*3600)."'")->select();
////					echo M('jztable')->_sql();
////					dump($jz);
//					for ($j=0;$j<count($jz);$j++){
// 						$rzzl=$jz[$j]['rzzl']*$this->sum/100.0 ;
//// 						echo $jz[$j]['rzzl'].'*'.$this->fen.'='.$jz[$j]['rzzl']*$this->fen/100.0.'<br>';
//						$this->sum+=$rzzl;
//						$this->sum=round($this->sum,2);
//						$this->gain+=$rzzl;
//						$this->drsy+=$rzzl;
//						$sy['mairu']=$this->mairu ;
//						
//						 
//						$sy['rzzl']=$jz[$j]['rzzl'];
// 						$sy['drsy']=round($this->drsy,2);	 
//						$this->sumdrsy+=round($this->drsy,2);
//						$this->drsy=0;
//						$sy['gain']=round($this->gain,2);;
//						$sy['sum']=round($this->sum,2);
//						$sy['gainlv']= round($sy['gain']/($sy['sum']-$sy['gain']),2)*100;
//						$sy['time']=$jz[$j]['time'];
//						$sy['fen']=round($this->fen,2);;
//						$syList[]=$sy;
//						unset($sy);
////						echo '<br>'.$jz[$j]['rzzl'].'*'.$this->sum/100.0.'aaaaaaaaaaaa'.$jz[$j]['rzzl']*$this->sum/100.0.'++++'.$rzzl.'=='.$this->gain."====".$jz[$j]['time'];
//					}
//				} 
//			} 
			return $syList;
	}
	/**
	 * 定投，默认定投100，返回定投列表
	 *
	 * @param unknown_type $userId
	 * @param unknown_type $code 
	 * @param unknown_type $begin
	 * @param unknown_type $end
	 */
	function getMoniList($userId,$code,$begin="2012-08-13 12:00:00",$end="2012-08-14 12:00:00"){  
		$jz=M('jztable')->where('code='.$code)->select(); 
		$jz=array_column($jz, 'time');
		
	    for($start = strtotime($begin); $start <= strtotime($end);$start += 24*3600)  //我这里是按每小时遍历，所以每次增加3600秒
	    { 
	    	if (!in_array(date('Y-m-d',$start), $jz))
	    	{continue;} 
	    	
			$t['user_id']=$userId;
			$t['code']=$code;
			$t['money']=100;
			$t['type']=1;
			$t['time']=date('Y-m-d H:i:s', $start) ;
			$list[]=$t;
//			unset()
//	        echo date('Y-m-d H:i:s',$start)."\n";
	    }
	    return $list;
	}
	/**
	 * 通过购买记录计算收益
	 *
	 * @param unknown_type $list
	 * @return unknown
	 */
	function getMoni($list){
	for ($i=0;$i<count($list);$i++){
			if ($list[$i]['type']==1){
					$jz=M('jztable')->where(" code=$this->code  and time = '".date('Y-m-d',strtotime($list[$i]['time']." +0 day") )."' ")->find();
					$t1 = strtotime($list[$i]['time']); 
					if (empty($jz)&&date('Y-m-d', time())==date('Y-m-d', $t1)){//当前天买的，并且没有利率呢
						continue;
					}
					    $rzzl=$jz['rzzl']*$this->sum/100.0;
						$this->sum+=$rzzl;
						$this->sum2=round($list[$i]['money']-$list[$i]['money']*$this->mrll,2);
						$sy['mairu']=$list[$i]['money'];
						$this->mairu=0; 
						$this->gain+=$rzzl;
						$sy['gain']=round($this->gain,2); ;
						$sxf=round($this->sum2*$this->mrll,2);
						$sy['sxf']=$sxf;
						$this->drsy+=round($rzzl-$sxf,2);;
						$sy['rzzl']=$jz['rzzl']; 
						$sy['drsy']=round($this->drsy,2); 
						$this->maifen=round(round($list[$i]['money']-$sxf,2)/$jz['dwjz'],2);
						$sy['maifen']=$this->maifen;
						$this->fen+=$this->maifen;
						$this->maifen=0;
						$sy['fen']=$this->fen;//round(round($list[$i]['money']+$this->drsy,2)/$jz['dwjz'],2);
						$this->drsy=0;
						$this->sum+=$this->sum2;//同一天多次购买
						$this->sum=round($this->sum,2);
						$sy['sum']=round($this->sum,2);//$this->fen/$jz['dwjz'];
						$sy['gainlv']= round($sy['gain']/($sy['sum']-$sy['gain']),2)*100;
						$sy['time']=$jz['time'];
						$syList[]=$sy;	
						$sy['drsy']=$this->drsy;//round($this->drsy,2);	 
						$this->sumdrsy+=round($this->drsy,2);
//						$sy['maifen']=$this->maifen;
//						$sy['sxf']=0;
//					  	$sy['mairu']=0;
						unset($sy);
						
						$this->sum2=0;
			}else{//卖出不考虑多次卖出这种了，否则和多次买入混在一块太乱了 
				$jz=M('jztable')->where(" code=$this->code  and time = '".date('Y-m-d',strtotime($list[$i]['time']." +0 day") )."' ")->find();
				$t1 = strtotime($list[$i]['time']); 
				if (empty($jz)&&date('Y-m-d', time())==date('Y-m-d', $t1)){//当前天买的，并且没有利率呢
					continue;
				}
 				$this->maichu=round($list[$i]['fen']*$jz['dwjz'],2);
						$sxf2=round($this->maichu*$this->mcll,2);
						$sy['sxf2']=$sxf2;
						$sy['rzzl']=$jz['rzzl']; 
						$this->fen-=$list[$i]['fen'];
				$this->sum=round($this->fen*$jz['dwjz'],2);
						$sy['gain']=round($this->gain,2); 
						$sy['fen']=round($this->fen,2); 
						$sy['sum']=round($this->fen*$jz['dwjz'],2);
						$sy['gainlv']= round($sy['gain']/($sy['sum']-$sy['gain']),2)*100;
					  	$sy['maichu']=round($this->maichu-$sxf2,2);
						$sy['maichufen']=$list[$i]['fen'];
						$this->maichu=0;  

						
						$sy['time']=$jz['time'];
						$syList[]=$sy; 
//					  	$sy['maichu']=$this->maichu;
//					  	$sy['mairu']=0;
//						$sy['maichufen']=0;
//						$sy['sxf2']=0;
						unset($sy);

			}
			if (count($list)>$i+1){//$i+1存在
					//购买之后的计算				
					//买和卖直接的时间段，买之后一天到卖当天3点前算当天的
					$jz=M('jztable')->where(" code=$this->code  and time between '".date('Y-m-d',strtotime($list[$i]['time']." +1 day")+9*3600)."' and 
					'".date('Y-m-d',strtotime($list[$i+1]['time']."-1 day")+9*3600)."'")->select();
//					echo M('jztable')->_sql();
//					dump($jz);
					for ($j=0;$j<count($jz);$j++){
 						$rzzl=$jz[$j]['rzzl']*$this->sum/100.0 ; 
						$this->sum+=$rzzl;
						$this->sum=round($this->sum,2);
						$this->gain+=$rzzl;
						$this->drsy+=$rzzl;
						$sy['mairu']=$this->mairu ;
						
						 
						$sy['rzzl']=$jz[$j]['rzzl'];
 						$sy['drsy']=round($this->drsy,2);	 
						$this->sumdrsy+=round($this->drsy,2);
						$this->drsy=0;
						$sy['gain']=round($this->gain,2);;
						$sy['sum']=round($this->sum,2);
						$sy['gainlv']= round($sy['gain']/($sy['sum']-$sy['gain']),2)*100;
						$sy['time']=$jz[$j]['time'];
						$sy['fen']=round($this->fen,2);;
						$syList[]=$sy;
						unset($sy);
//						echo '<br>'.$jz[$j]['rzzl'].'*'.$this->sum/100.0.'aaaaaaaaaaaa'.$jz[$j]['rzzl']*$this->sum/100.0.'++++'.$rzzl.'=='.$this->gain."====".$jz[$j]['time'];
					}
				} 
			}
			return $syList;
	}
}
?>