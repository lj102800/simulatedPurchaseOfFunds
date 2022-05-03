<?php
namespace Home\Controller;
use Think\Controller;
use Common\Util;
 
class YjzsController extends Controller {
	public function index(){
		$this->display(); 
	}
	 function __construct(){ 
        parent::__construct(); 
	} 
	/*
		业绩走势
	*/
	 public function yjzs(){
 		$code=I('request.code');
		$codes=M('jztable')->field('max(time) as max,min(time) as min')->where('code='.$code)->select();
// echo M('jztable')->_sql();
// dump($codes); die();
		$min=substr($codes[0]['min'],0,4);
		$max=substr($codes[0]['max'],0,4);
		for ($j=$min; $j <=$max ; $j++) {  
			$where="`code` ='$code' and ";
			$where.="`time` between '$j-01-01' and '".($j)."-12-31'"; 
			// die();
			$new2 =M('jztable')->where( $where )->order('time desc')->select(); 
			// echo M('jztable')->_sql().'<br>';
			$v=0;// dump($new2);
			$s2="["; 
			for ($i=count($new2)-1;$i>=0;$i--){
				$brr[] = $v;
				$day[] =$new2[$i]['time'];
				if ($i!=count($new2)-1)$s2.=",";
				 $s2.="[Date.UTC(".gmdate('Y,m,d', (strtotime($new2[$i]['time'])-30*24*3600))."),$v]";
				 $v+=$new2[$i]['rzzl'];
			} 
			$s2.="]";//dump($s2);
			$infoslist[$j]=$s2; 
			$container[$j-$min]='container'.($j-$min+1);
		}
		// dump($infoslist);
					$this->assign('infoslist',$infoslist);

/*------------------------------------------------------------------------------------------*/
		$width=$limit*10;
		// $this->assign('width',$width);

		$this->assign('container_list',$container);
		$this->assign('width',3660);
		$limit=8;
		$this->display(); 
	}  
}