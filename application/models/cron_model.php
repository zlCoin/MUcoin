<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *
 *
 * @package     cron
 * @author      wangyouworld
 * @copyright   wangyouworld copyright (c) 2016
 * @filesource
 */
class Cron_model extends Base_model {
	public $enMsg = FALSE;
	public $startTime = ARRAY();
	public $stopTime = ARRAY();

	/* 设置是否以 调试方式运行  */
	public function setLogShow($msg='') {
		$this->enMsg = ($msg == 'debug') ? TRUE : FALSE;
	}

	/* 调试方式将显示日志
	 * 如果提供 $show 参数 将忽略 enMsg 参数直接显示
	 */
	public function msg($msg='', $show=FALSE) {
		$br = ($this->input->is_cli_request()) ? PHP_EOL : '<br />';
		if ($this->enMsg || $show) echo $msg.$br;
	}

	public function timeEnd() {
		$this->etime = microtime(true);//获取程序执行结束的时间
		$total = $this->etime - $this->stime;   //计算差值
	}

	public function get_microtime() {
		list($usec, $sec) = explode(' ', microtime());
		return ((float)$usec + (float)$sec);
	}

	public function runStart($i=0) {
		$this->startTime[$i] = $this->get_microtime();
	}

	public function runStop($i=0) {
		$this->stopTime[$i] = $this->get_microtime();
		return round(($this->stopTime[$i] - $this->startTime[$i]), 3);
	}

	//赠送积分 执行函数  时间条件
	// 重写 a_bonus_model.php get_row_byymd
	// 增加自定义时间
	public function get_row_byymd($time=0) {
		$nowTime = $time > 0 ? $time : time();
		$where['ymd']=date("Ymd", $nowTime);
		$where['dtime']=0;
		$this->db->where($where);
		$query = $this->db->get('a_bonus', 1);
		$data = ARRAY();
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $val) {
				$data = $val;
				break;
			}
		}
		return $data;
	}

	// 重写 a_bonus_model.php start
	// 增加自定义时间
	public function start($time=0) {
		$nowTime = $time > 0 ? $time : time();
		$data['ymd']=date("Ymd", $nowTime);
		$data['dividend']=0;
		$data['management']=0;
		$data['number']=0;
		$data['remark']="";
		$data['state']=0;
		$data['ctime']=$nowTime;
		$this->db->set($data);
		$query = $this->db->insert ( 'a_bonus' );
		return $this->db->insert_id();
	}
	// 重写 a_bonus_model.php start
	// 增加自定义时间
	public function get_dividend_member($time,$limit="", $ymd=''){
		$ymd = $ymd > 0 ? $ymd : time();
		$this->db->select('free_stock_id as free_stock_id,parent_id_count as parent_id_count,member_id as member_id,user as user,time as time,number as number,day_dividend  as day_dividend,clue as clue,level as level,no as no,cumulative_dividend as cumulative_dividend,ctime as ctime');
		$this->db->from('free_stock');
		$this->set_order_by('member_id,DESC');
		$this->set_limit($limit);
		//echo $limit;
		$where['time <']=$time;

		$where['expiration_date >=']=mktime(0, 0, 0,date("m",$ymd), date("d",$ymd), date("Y",$ymd));
		$where['ymd  <>']=date("Ymd",$ymd);
		$where['lock']=0;
		$where['dtime']=0;
		return $this->fetch(NULL, $where);
	}

	/* 批量写入数据 按次 */
	public function batchInsertData($table, $data, $maxLine=1000) {
		if (empty($table) || empty($data) || $maxLine <=0) return FALSE;

		$i = 0;
		$tmp = ARRAY();
		foreach ($data as $val) {
			$tmp[$i] = $val;
			if ($i > $maxLine) {
				$this->db->insert_batch($table, $tmp);
				$i = 0;
				$tmp = ARRAY();
			} else {
				$i += 1;
			}
		}

		if (!empty($tmp)) {
			$this->db->insert_batch($table, $tmp);
		}

		return TRUE;

	}

	public function batchUpdateData($table, $data, $id, $maxLine=1000) {
		if (empty($table) || empty($data) || $maxLine <=0) return FALSE;
		$this->db->update_batch($table, $data, $id);

		$i = 0;
		$tmp = ARRAY();
		foreach ($data as $val) {
			$tmp[$i] = $val;
			if ($i > $maxLine) {
				$this->db->update_batch($table, $tmp, $id);
				$i = 0;
				$tmp = ARRAY();
			} else {
				$i += 1;
			}
		}

		if (!empty($tmp)) {
			$this->db->update_batch($table, $tmp, $id);
		}

		return TRUE;

	}

	public function get_management($clue_value,$level_value,$level,$time, $vtime=''){
		$ymd = $vtime > 0 ? $vtime : time();
		$this->db->from('free_stock');
		$this->db->select('member_id as member_id,level as level,day_dividend as day_dividend');
		$this->db->like('clue', $clue_value."-", 'after');
		$this->set_order_by('level,ASC');
		$where['level <=']=$level_value;
		$where['time <']=$time;
		$where['expiration_date >=']=mktime(0, 0, 0,date("m", $ymd), date("d", $ymd), date("Y", $ymd));
		$where['lock']=0;
		$where['dtime']=0;
		return $this->fetch(NULL, $where);
	}

	/* 重写 my_models_helper.php fun_get_member_management_bonus 函数 增加自定义时间*/
	public function fun_get_member_management_bonus($member_id,$parent_id_count,$key,$level,$cap_amount,$time, $vtime='' )
	{
		$vtime = $vtime > 0 ? $vtime : time();
		$member_day_dividend=$this->get_management($key,$level+$parent_id_count,$level,$time, $vtime);
		//echo $CI->db->last_query();echo "<br/>";
		$member_day_dividend_array=array();			
		foreach($member_day_dividend  as $key=>$row){		
			if(isset($member_day_dividend_array[$row->level-$level][$row->member_id]))
				$member_day_dividend_array[$row->level-$level][$row->member_id]+=$row->day_dividend;
			else
				$member_day_dividend_array[$row->level-$level][$row->member_id]=$row->day_dividend;
		}
		//print_r($member_day_dividend_array);die();
		if(isset($member_day_dividend_array[1])){
			$member_level_1_count=count($member_day_dividend_array[1]);
			if($member_level_1_count>10)
				$member_level_1_count=10;
		}else
			return 0;
		//echo $member_level_1_count;echo "<br/>";
		$day_dividend=0;
		foreach($member_day_dividend_array  as $key=>$member_level){	
			if($member_level_1_count<$key){
				break;
			}
			foreach($member_level as $key1=>$value)
				$day_dividend+=$value*( ((10-$key)/100)+0.01);			
		}
		//echo $day_dividend;
		//	die();
		if($day_dividend>$cap_amount)
			return $cap_amount;
		else
			return $day_dividend==""?"0":$day_dividend;
	}




	public function test($free_stock_list_a, $name, $management_data, $lbl1='member_id', $lbl2='ymd') {


		// echo $name,'<br>';
		// echo count($management_data),'<br>';
		$tmp = ARRAY();
		foreach ($management_data as $val) {
			$lbl = $val[$lbl1].'_'.$val[$lbl2];
			if (!isset($tmp[$lbl])) {
				$tmp[$lbl]['num'] = 0;
			}
			$tmp[$lbl]['num'] += 1;
			$tmp[$lbl]['member_id'] = $val['member_id'];
		}
		foreach ($tmp as $key =>$val) {
			//if ($val['num'] > $free_stock_list_a[$val['member_id']]) echo $key,',',$val['num'],',',$free_stock_list_a[$val['member_id']],'<br>';
		}
		//echo '<hr>';
	}

}
