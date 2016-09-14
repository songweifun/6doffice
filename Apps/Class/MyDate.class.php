<?php
/**
 * PHP��Ŀ��ʹ�� - PHP��Ŀ���
 * Copyright (c) 2006-2008 ������Ѷ
 * All rights reserved.
 * δ����ɣ���ֹ������ҵ��;��
 *
 * @package    Util
 * @author     ��־�� <dzjzmj@163.com>
 * @copyright  2006-2008 Walk Watch
 * @version    v1.0
 */

/**
 * MyDate ʱ����
 * @package Util
 */
class MyDate {

	/**
	 * @var int $firstDayOfWeek һ�ܵ�һ�������ڼ�0��ʾ������
	 * @access private
	 */
	private $firstDayOfWeek = 1;

	/**
	 * @var string $datetime ����ʱ���ַ���
	 * @access private
	 */
	private $datetime;

	/**
	 * @var string $date �����ַ���
	 * @access private
	 */
	private $date;

	/**
	 * @var int $timestamp ʱ���
	 * @access private
	 */
	private $timestamp;

	/**
	 * ���캯��
	 * @param string $date ����ʱ���ַ�����ʽΪ0000-00-00 00:00:00����û��ʱ��
	 */
	public function __construct ($date = NULL) {
		$this->setDateTime($date);
	}

	/**
	 * ���õ�ǰʱ��
	 * @param string $timezone ʱ��
	 * @return void
	 */
	public function setDefaultTimezone($timezone) {
		date_default_timezone_set($timezone);
		return;
	}

	/**
	 * ��������ʱ��
	 * @param string $date
	 * @return void
	 */
	public function setDateTime($date=NULL) {
		if ($date) {
			if (!is_numeric($date)) {
				$this->timestamp = $this->toTimeStamp($date);
			} else {
				$this->timestamp = (int)$date;
			}
		} else {
			$this->timestamp = time();
		}
		$this->datetime = $this->format();
		$this->date      = $this->format('date');
	}

	/**
	 * ʱ���������
	 * @param int $increment ����
	 * @param string $unit ��λ
	 * @param string $returnFormat ���ص�ʱ���ʽ
	 * @return void
	 */
	public function add($increment, $unit='s', $returnFormat = NULL) {
		$increment = intval($increment);
		$source = $this->timestamp;
		switch ($unit)
		{
			case 'yy' : $result = $source + $increment * 31536000;	break;	//��
			case 'mm' : $result = $source + $increment * 2592000;	break;	//��
			case 'dd' : $result = $source + $increment * 86400;		break;	//��
			case 'h'  : $result = $source + $increment * 3600;		break;	//ʱ
			case 'm'  : $result = $source + $increment * 60;		break;	//��
			default	  : $result = $source + $increment;				break;	//��
		}
		if ($returnFormat) {
			$result = $this->format($returnFormat, $result);
		}
		return $result;
	}
	
	/**
	 * ʱ��ת����̬����
	 * @param string $formatTo ���ظ�ʽ
	 * @param mixed $source ʱ��Դ
	 * @return string
	 */	
	public static function transform($formatTo = 'date',$source) {
		if (!is_numeric($source)) { 
			try {
				$source = MyDate::toTimeStamp($source);
			}catch (Exception $e){
				
			}
		}
		if ($formatTo!='timestamp') {
			switch (strtolower($formatTo))
			{
				case 'chinese' : //���ĸ�ʽ����YYYY��MM��DD�� HH:MM:SS��
					$result = date("Y��m��d�� H:i:s", $source); break ;
				case 'cdate':
					$result = date("Y��m��d��", $source); break ;
				case 'date':
					//$result = $source;break;
					$result = date("Y-m-d", $source); break ;
				case 'time':
					$result = date("H:i:s", $source); break ;
				case 'standard' : //��׼��ʽ����YYYY-MM-DD HH:MM:SS��
					$result = date("Y-m-d H:i:s", $source); break;
				case 'noyear' :
					$result = date("m-d",$source);break;
				default : 
					$result = date($formatTo, $source);
			}
		} else {
			$result = $source;
		}
		return $result;
	}

	/**
	 * ʱ���������
	 * @param string $source ԭʱ��
	 * @param string $dest Ŀ��ʱ��
	 * @param string $unit ��λ
	 * @param bool $roundIt �Ƿ񽫽����������
	 * @return int
	 */
	public static function compare($source, $dest, $unit, $roundIt = false) {
		if ($source&&$dest)
		{
			if (is_object($source) && get_class($source)=='MyDate') {
				$source = $source->getTimeStamp();
			}
			if (is_object($dest) && get_class($dest)=='MyDate') {
				$dest = $dest->getTimeStamp();
			}
			if (!is_numeric($source)) {
				$source = MyDate::toTimeStamp($source); 
			}
			if (!is_numeric($dest)) {
				$dest = MyDate::toTimeStamp($dest);
			}
			$result = $source - $dest ;
			if ($result!=0)	{
				switch ($unit) {
					case 'yy' : $result = $result/31536000;	break;	//��
					case 'mm' : $result = $result/2592000;	break;	//��
					case 'dd' : $result = $result/86400;	break;	//��
					case 'h'  : $result = $result/3600;		break;	//ʱ
					case 'm'  : $result = $result/60;		break;	//��
					default	  : break;								//��
				}
			}
			if ($roundIt) {
				$result = intval(round($result));
			}
		} else {
			$result = false ;
		}
		return $result;
	}

	/**
	 * ���������µ�����
	 * @return int
	 */
	public function daysOfMonth ($year=NULL,$month=NULL) {
		if ($year===NULL) {
			$year = $this->getPart('yy');
		}
		if ($month===NULL) {
			$month = $this->getPart('mm');
		}
		if ($month==2)
		{
			if (($year % 4 == 0 && $year % 100 != 0) || $year % 400 == 0)
				$result = 29;
			else
				$result = 28;
		}
		elseif ($month == 4 || $month == 6 || $month == 9 || $month == 11)
			$result = 30;
		else
			$result = 31;
		return $result;
	}

	/**
	 * ���������µĵ�һ������
	 * @return int
	 */
	public function getFirstDayOfMonth ($format = 'timestamp') {
		$day = $this->getPart('yy') . '-' . $this->getPart('mm') . '-' . '01';
		if ($format=='timestamp') {
			$day = (int)$this->toTimeStamp($day);
		}
		return $day;
	}
	/**
	 * ���������µ����һ������
	 * @return int
	 */
	public function getLastDayOfMonth ($format = 'timestamp') {
		$day = $this->getPart('yy') . '-' . $this->getPart('mm') . '-' . $this->daysOfMonth();
		if ($format=='timestamp') {
			$day = (int)$this->toTimeStamp($day);
		}
		return $day;
	}

	/**
	 * ��ʽ���������
	 * @param string $formatTo ���ڸ�ʽ
	 * @return int
	 */
	public function format ($formatTo='standard',$timestamp = NULL) {
		if ($timestamp!==NULL) {
			$source = $timestamp;
			if (!$source) {
				return '';
			}
		} else {
			$source = $this->timestamp;
		}
		
		switch (strtolower($formatTo))
		{
			case 'chinese' : //���ĸ�ʽ����YYYY��MM��DD�� HH:MM:SS��
				$result = date("Y��m��d�� H:i:s", $source); break ;
			case 'cdate':
				$result = date("Y��m��d��", $source); break ;
			case 'date':
				$result = date("Y-m-d", $source); break ;
			case 'time':
				$result = date("H:i:s", $source); break ;
			case 'standard' : //��׼��ʽ����YYYY-MM-DD HH:MM:SS��
				$result = date("Y-m-d H:i:s", $source); break;
			default : 
				$result = date($formatTo, $source);
		}
		return $result;
	}
		
	/**
	 * ȡʱ�����ڼ���
	 * @return int
	 */
	public function getQuarter() {
		$month = $this->getPart('mm');
		if ($month<=3) {
			return 1;
		} else if ($month>=4 && $month<=6) {
			return 2;
		} else if ($month>=7 && $month<=9) {
			return 3;
		} else {
			return 4;
		}
	}
	
	/**
	 * ȡʱ���������е�Ѯ�ĵ�һ��
	 * @param string ����ʱ���ʽ
	 * @return string
	 */
	public function getFirstDayOfQuarter($format='timestamp') {
		$quarter = $this->getQuarter();
		$year = $this->getPart('yy');
		switch ($quarter) {
		case 1:
			$month = 1;
			break;	
		case 2:
			$month = 4;
			break;	
		case 3:
			$month = 7;
			break;	
		default :
			$month = 10;
			break;	
		}
		$day = $year . '-' . $month . '-' . '01';
		
		if ($format=='timestamp') {
			$day = (int)$this->toTimeStamp($day);
		}
		return $day;
	}
	
	/**
	 * ȡʱ���������е�Ѯ�����һ��
	 * @param string ����ʱ���ʽ
	 * @return string
	 */
	public function getLastDayOfQuarter($format='timestamp') {
		$quarter = $this->getQuarter();
		$year = $this->getPart('yy');
		switch ($quarter) {
		case 1:
			$month = 4;
			break;	
		case 2:
			$month = 6;
			break;	
		case 3:
			$month = 9;
			break;	
		default :
			$month = 12;
			break;	
		}
		$dd = $this->daysOfMonth($year,$month);
		$day = $year . '-' . $month . '-' . $dd;
		
		if ($format=='timestamp') {
			$day = (int)$this->toTimeStamp($day);
		}
		return $day;
	}
	
	/**
	 * ȡʱ���������е�Ѯ��1��Ѯ��2��Ѯ,3��Ѯ
	 * @return int
	 */
	public function getPeriod() {
		$day = $this->getPart('dd');
		if ($day<11) {
			return 1;
		} else if ($day>=11 && $day<=20) {
			return 2;
		} else {
			return 3;
		}
	}
	/**
	 * ȡ���ڵ�һ������
	 * @param string $part ���ֵĸ�ʽ
	 * @return string
	 */
	public function getPart ($part) {
		$source = $this->timestamp;
		switch($part)
		{
			case 'yy' : $result = intval(date("Y", $source)); break; //��
			case 'mm' : $result = intval(date("m", $source)); break; //��
			case 'dd' : $result = intval(date("d", $source)); break; //��
			case 'w'  : $result = intval(date("N", $source)); break; //���� [1-7] "1"��ʾ����һ
			case 'cw' : $index = date("N", $source); //��������
						$week_array = array('1'=>'һ', '2'=>'��', '3'=>'��', '4'=>'��', '5'=>'��', '6'=>'��', '7'=>'��');
						$result = '����' . $week_array[$index];

						break;
			case 'h'  : $result = intval(date("H", $source)); break; //ʱ
			case 'm'  : $result = intval(date("i", $source)); break; //��
			case 's'  : $result = intval(date("s", $source)); break; //��
			case 'yw' : $result = intval(date("W", $source)); break; //һ���еڼ���
			case 'yd' : $result = intval(date("z", $source)); break; //һ���еڼ���
			default   :  //ȫ��
				$week_array = array('1'=>'һ', '2'=>'��', '3'=>'��', '4'=>'��', '5'=>'��', '6'=>'��', '7'=>'��');
				$result = array(
						'yy' => intval(date("Y", $source)), //��
						'mm' => intval(date("m", $source)), //��
						'dd' => intval(date("d", $source)), //��
						'w'  => intval(date("N", $source)), //���� [1-7] "1"��ʾ����һ
						'cw' => '����' . $week_array[date("N", $source)], //��������
						'h'  => intval(date("H", $source)), //ʱ
						'm'  => intval(date("i", $source)), //��
						's'  => intval(date("s", $source)), //��
						);
				break;
		}
		return $result;
	}

	/**
	 * ������ת����ʱ���
	 * @param string $dateTimeString ����ʱ��
	 * @return int
	 */
	private function toTimeStamp ($dateTimeString = NULL) {
		if (!$dateTimeString) {
			$dateTimeString = time();
		}
		$numeric = '';
		$add_space = false;
		for($i=0;$i<strlen($dateTimeString);$i++) {
			if(strpos('0123456789',$dateTimeString[$i])===false) {
				if($add_space) {
					$numeric .= ' ';
					$add_space = false;
				}
			} else {
				$numeric .= $dateTimeString[$i];
				$add_space = true;
			}
		}
		
		$numeric_array = explode(' ',$numeric,6);
		if(sizeof($numeric_array)<3 || ($numeric_array[0]==0 && $numeric_array[1]==0 && $numeric_array[2]==0)) {
			throw new Exception($dateTimeString . ' is an invalid parameter', 5);
		} else {
			$result = mktime(intval($numeric_array[3]),	intval($numeric_array[4]), intval($numeric_array[5]),
								intval($numeric_array[1]), intval($numeric_array[2]), intval($numeric_array[0])) ;
		}
		
		return $result;
	
	}

	/**
	 * ȡ���ܵ�һ�������
	 * @return string
	 */
	public function getFirstDayOfWeek ($format='') {
		$todayOfWeek = $this->getPart('w');
		
		/* �˴��������� */
		$firstDay = $this->add($this->firstDayOfWeek-$todayOfWeek,'dd',$format);
		return $firstDay;
	}

	/**
	 * ȡʱ���
	 * @return int
	 */
	public function getTimeStamp() {
		return $this->timestamp;
	}

	/**
	 * ȡʱ�����ڴ�
	 * @return string
	 */
	public function getDateTime() {
		return $this->datetime;
	}

	/**
	 * ȡ���ڴ�
	 * @return string
	 */
	public function getDate() {
		return $this->date;
	}

	/**
	 * ����ÿ�ܵ�һ�������ڼ�
	 * @param string $week ����0-6
	 * @return void
	 */
	public function setFirstDayOfWeek($week = 1) {
		$this->firstDayOfWeek = $week;
	}
	
	/**
	 * ʱ��ת��������������ʱ���
	 * @param string $time
	 * @return int
	 */
	public static function timeToSec($time) {
		$p = explode(':',$time);
		$c = count($p);
		if ($c>1) {
			$hour    = intval($p[0]);
			$minute  = intval($p[1]);
			$sec     = intval($p[2]);
		} else {
			throw new Exception('error time format');
		}
		$secs = $hour*3600 + $minute*60 + $sec;
		return $secs;
	}
}
?>