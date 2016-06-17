<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 *
 *
 *
 * @package     chuanqi
 * @subpackage  models
 * @category    models
 * @author      hyw
 * @copyright   copyright (c) 2012
 * @filesource
 */
class Week_model extends Base_model {
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


	// 开始函数 增加自定义时间
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
		$query = $this->db->insert ('a_bonus');
		return $this->db->insert_id();
	}
	// 增加自定义时间
	public function get_dividend_member($time,$limit="", $ymd=''){
		$ymd = $ymd > 0 ? $ymd : time();
		$this->db->select('free_stock_id as free_stock_id,parent_id_count as parent_id_count,member_id as member_id,user as user,time as time,number as number,day_dividend  as day_dividend,clue as clue,level as level,no as no,cumulative_dividend as cumulative_dividend,ctime as ctime');
		$this->db->from('free_stock');
		$this->set_order_by('member_id,DESC');
		$this->set_limit($limit);
		//echo $limit;
		//$where['time <']=$time;
		//$where['expiration_date >=']=mktime(0, 0, 0,date("m",$ymd), date("d",$ymd), date("Y",$ymd));
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
}
 