<?php 
function getNumByScore($score,$array,$field ='sell_num'){
	//print_rr($array);
	//$array = array_reverse($array,true);
	foreach($array as $a_level){
		if($score < $a_level['score']){
			return $a_level[$field];
		}else{
			continue;
		}
		//返回最后一个
		return $a_level[$field];
	}
}
return array (
	1 => array('score'=>4000,'sell_num'=>30,'rent_num'=>30,'pic'=>'1'),
	2 => array('score'=>6000,'sell_num'=>30,'rent_num'=>30,'pic'=>'2'),
	3 => array('score'=>8000,'sell_num'=>30,'rent_num'=>30,'pic'=>'3'),
	4 => array('score'=>10000,'sell_num'=>30,'rent_num'=>30,'pic'=>'4'),
	5 => array('score'=>14000,'sell_num'=>30,'rent_num'=>30,'pic'=>'5'),
	6 => array('score'=>20000,'sell_num'=>60,'rent_num'=>60,'pic'=>'6'),
	7 => array('score'=>28000,'sell_num'=>60,'rent_num'=>60,'pic'=>'7'),
	8 => array('score'=>38000,'sell_num'=>60,'rent_num'=>60,'pic'=>'8'),
	9 => array('score'=>50000,'sell_num'=>60,'rent_num'=>60,'pic'=>'9'),
	10 =>array('score'=>66000,'sell_num'=>60,'rent_num'=>60,'pic'=>'10'),
	11 =>array('score'=>90000,'sell_num'=>60,'rent_num'=>60,'pic'=>'11'),
	12 =>array('score'=>120000,'sell_num'=>60,'rent_num'=>60,'pic'=>'12'),
	13 =>array('score'=>160000,'sell_num'=>60,'rent_num'=>60,'pic'=>'13'),
	14 =>array('score'=>210000,'sell_num'=>60,'rent_num'=>60,'pic'=>'14'),
	15 =>array('score'=>300000,'sell_num'=>60,'rent_num'=>60,'pic'=>'15'),
);

?>