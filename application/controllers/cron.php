<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cron extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}
	public function index($time='', $debug='') {

		$writeDb = TRUE; // 是否操作数据库
		$debugTest = FALSE; // 是否测试模式
		set_time_limit(0);
		ini_set('memory_limit', '512M');
		date_default_timezone_set('Asia/Shanghai');

		$maxRecord = 1000; // 单次最大写入数量
		$this->load->model('cron_model');
		$this->cron_model->setLogShow($debug);
		$this->cron_model->runStart();

		$this->cron_model->msg('--- '. date("Y-m-d H:i:s") .' ---', TRUE);
		$this->cron_model->msg('', TRUE);
		$nowTime = empty($time) ? time() : strtotime($time);
		$nowYmd = date("Ymd", $nowTime);
		$nowY = date("Y", $nowTime);
		$nowm = date("m", $nowTime);
		$nowd = date("d", $nowTime);

		$this->cron_model->msg('set time : '. date("Y-m-d", $nowTime), TRUE);
		/* 前置判断 查询当前是否已经写入数据 */
		$this->cron_model->runStart(1);
		$a_bonus=$this->cron_model->get_row_byymd($nowTime);

		// $this->cron_model->msg('$this->cron_model->get_row_byymd :'. $this->db->last_query());

		if (empty($a_bonus)) {
			$a_bonus_id=$this->cron_model->start($nowTime);
			// $this->cron_model->msg('$this->cron_model->start :'. $this->db->last_query());
		} else {
			$a_bonus_id=$a_bonus['a_bonus_id'];
		}

		$this->cron_model->msg('get_row_byymd run time : '. $this->cron_model->runStop(1).' s.');

		$this->cron_model->runStart(1);
		$this->load->model('free_stock_model');
		$this->free_stock_model->update_repair_data();
		$this->cron_model->msg('update_repair_data run time : '. $this->cron_model->runStop(1).' s.');

		//是否插入了最新日期记录
		$this->cron_model->runStart(1);
		$this->load->model('management_day_model');
		$management_member_row=$this->management_day_model->get_member_id_byymd($nowYmd);
		if(empty($management_member_row)){
			$this->management_day_model->add_ymd($nowYmd);
		}
		$this->cron_model->msg('management_day_model add_ymd run time : '. $this->cron_model->runStop(1).' s.');

		// 必须以 CLI 方式运行
		if ($this->input->is_cli_request()) {
			$this->cron_model->msg('program start run...');

			$this->load->model('a_bonus_model');
			$this->load->model('system_switch_model');

			$system_switch=$this->system_switch_model->get_row_byid(1);
			// 为 0 功能关闭
			if($system_switch->day_dividend == 0) {
				//$this->cron_model->msg('system integrator pause,program stop.', TRUE);
				// exit(0);
			}
			$this->load->model('system_set_model');
			$system_set=$this->system_set_model->get_row_byid(1);
			$w=date("w", $nowTime);//$w=="6" || $w=="0" ||  周六周日不送
			$this->cron_model->msg('week time: '.date('Y-m-d H:i:s', $nowTime).', week val: '.$w, TRUE);
			if($w=="1" || $w=="2"  || $w=="3"  || $w=="4"  || $w=="5" ){
				$dividend=0;
				$management=0;
				$this->load->model('bonus_model');//
				$this->load->model('management_model');//管理积分赠送记录自由金现金记录
				$this->load->model('member_model');//用户表更新
				$this->load->model('cash_model');//现金积分
				$this->load->model('free_gold_model');//自由金记录
				$this->load->model('dividend_model');

				/* 不限制读取数量 读取全部 */
				$this->cron_model->runStart(1);
				$free_stock_list=$this->cron_model->get_dividend_member($system_set->dividend_time, '', $nowTime);
				$this->cron_model->msg('user number : '.count($free_stock_list), TRUE);
				$this->cron_model->msg('get_dividend_member run time : '. $this->cron_model->runStop(1).' s.');

				$bonus_data=array();
				$dividend_management=array();
				$data_dividend=array();
				$management_data=array();
				$cash_data=array();
				$free_gold_data=array();
				$dividend_data=array();
				$member_array=array();
				$member_id_array=array();
				$all_dividend=0;
				$this->cron_model->runStart(1);
				$free_stock_list_a = ARRAY();
				$free_stock_list_0 = ARRAY(); // 用于统计 0 股权人员
				$free_stock_list_sum = ARRAY(); // 统计股权信息
				foreach($free_stock_list as $key=>$row){

					// 用于测试统计股数
					if (!isset($free_stock_list_a[$row->member_id])) $free_stock_list_a[$row->member_id] = 0;

					$free_stock_list_a[$row->member_id] += $row->number;

					$lbl_0 = $row->free_stock_id.'_'.$row->member_id;
					if ($row->number == 0) {
						if (!isset($free_stock_list_0[$lbl_0])) {
							$free_stock_list_0[$lbl_0]['id'] = $row->free_stock_id;
							$free_stock_list_0[$lbl_0]['member_id'] = $row->member_id;
							$free_stock_list_0[$lbl_0]['user'] = $row->user;
						}
					}

					$lbl_sum = $row->member_id;
					if (!isset($free_stock_list_sum[$lbl_sum])) {
						$free_stock_list_sum[$lbl_sum] = ARRAY();
						$free_stock_list_sum[$lbl_sum]['i'] = 0;
						$free_stock_list_sum[$lbl_sum]['number'] = 0;
						$free_stock_list_sum[$lbl_sum]['sum'] = 0;
						$free_stock_list_sum[$lbl_sum]['list'] = ARRAY();
						$free_stock_list_sum[$lbl_sum]['list'][$row->free_stock_id] = ARRAY(
							'member_id' => 0,
							'day_dividend' => 0,
							'number' => 0,
							'sum' => 0
						);
					}
					$free_stock_list_sum[$lbl_sum]['list'][$row->free_stock_id] = ARRAY(
						'member_id' => $row->member_id,
						'day_dividend' => $row->day_dividend						
					);
					$free_stock_list_sum[$lbl_sum]['i'] += 1; 
					$free_stock_list_sum[$lbl_sum]['number'] = $free_stock_list_sum[$lbl_sum]['number']+$row->number;
					$free_stock_list_sum[$lbl_sum]['sum'] = $free_stock_list_sum[$lbl_sum]['sum']+$row->day_dividend;

					$bonus_data[$key]['member_id']=$row->member_id;
					$bonus_data[$key]['user']=$row->user;
					$bonus_data[$key]['dividend']=$row->day_dividend;
					$bonus_data[$key]['management']=0;
					$bonus_data[$key]['ymd']=$nowYmd;
					$bonus_data[$key]['y']=$nowY;
					$bonus_data[$key]['m']=$nowm;
					$bonus_data[$key]['d']=$nowd;
					$bonus_data[$key]['ctime']=$nowTime;
					//************************************更新自由股表
					$data_dividend[$key]["cumulative_dividend"]=$row->cumulative_dividend+$bonus_data[$key]['dividend'];
					$data_dividend[$key]["ymd"]=$nowYmd;//更新时间
					$data_dividend[$key]["time"]=$row->time+1;//次数加1
					if($row->time+1>=$system_set->dividend_time)  //是否超过
						$data_dividend[$key]["state"]=1;
					$data_dividend[$key]["free_stock_id"]=$row->free_stock_id;
					//*************************************
					$dividend_data[$key]['member_id']=$row->member_id;
					$dividend_data[$key]['user']=$row->user;
					$dividend_data[$key]['no']=$row->no;
					$dividend_data[$key]['number']=$row->number;
					$dividend_data[$key]['day_dividend']=$row->day_dividend;
					$dividend_data[$key]['time']=$row->time+1;
					//账户结余积分
					$dividend_data[$key]['cumulative_dividend']=$row->cumulative_dividend+$row->day_dividend;
					$dividend_data[$key]['btime']=$row->ctime;
					$dividend_data[$key]['ymd']=$nowYmd;
					$dividend_data[$key]['y']=$nowY;
					$dividend_data[$key]['m']=$nowm;
					$dividend_data[$key]['d']=$nowd;
					$dividend_data[$key]['ctime']=$nowTime;
					//*************************************	会员数据
					$member_id_array[$row->member_id]=$row->member_id;
					$member_array[$row->member_id]['member_id']=$row->member_id;
					$member_array[$row->member_id]['user']=$row->user;
					$member_array[$row->member_id]['clue']=trim($row->clue);
					$member_array[$row->member_id]['level']=$row->level;
					if(isset($member_array[$row->member_id]['day_dividend']))
						$member_array[$row->member_id]['day_dividend']+=$row->day_dividend;
					else
						$member_array[$row->member_id]['day_dividend']=$row->day_dividend;
					$all_dividend+=$bonus_data[$key]['dividend'];
				}
				unset($free_stock_list);
				$this->cron_model->msg('free_stock_list data run time : '. $this->cron_model->runStop(1).' s.');

				$all_management=0;
				if(!empty($member_array)){
					$management_member_row=$this->management_day_model->get_member_id_byymd($nowYmd);
					if(isset($member_array[$management_member_row->member_id])){
						$this->cash_model->update_cash_currency_byymd($member_array[$management_member_row->member_id]['day_dividend'],$management_member_row->member_id);
						$this->member_model->add_cash($member_array[$management_member_row->member_id]['day_dividend'],$management_member_row->member_id);
						unset($member_array[$management_member_row->member_id]);
					}

					$countI = 0;
					$this->cron_model->runStart(1);
					foreach($member_array  as $member_key=>$member_row){
						$management=$this->cron_model->fun_get_member_management_bonus($member_row['member_id'],10,$member_row['clue'],$member_row['level'],$system_set->cap_amount,$system_set->dividend_time, $nowTime);
						//echo $management;die();
						$cash_currency=0;
						$free_gold=0;
						if($management>0){
							$cash_currency=$management*0.7;
							$free_gold=$management*0.3;
							$management_data[$member_key]['member_id']=$member_row['member_id'];
							$management_data[$member_key]['money']=$management;
							$management_data[$member_key]['cash']=$cash_currency;
							$management_data[$member_key]['free_gold']=$free_gold;
							$management_data[$member_key]['type']="a_bonus";
							$management_data[$member_key]['ymd']=$nowYmd;
							$management_data[$member_key]['y']=$nowY;
							$management_data[$member_key]['m']=$nowm;
							$management_data[$member_key]['d']=$nowd;
							$management_data[$member_key]['ctime']=$nowTime;
							//echo $this->db->last_query();echo "<br/>";
							if($free_gold>0){
								$free_gold_data[$member_key]['member_id']=$member_row['member_id'];
								$free_gold_data[$member_key]['user']=$member_row['user'];
								$free_gold_data[$member_key]['type']="a_bonus";
								$free_gold_data[$member_key]['free_gold']=$free_gold;
								$free_gold_data[$member_key]['ymd']=$nowYmd;
								$free_gold_data[$member_key]['y']=$nowY;
								$free_gold_data[$member_key]['m']=$nowm;
								$free_gold_data[$member_key]['d']=$nowd;
								$free_gold_data[$member_key]['ctime']=$nowTime;
							}

							$all_management+=$management;

						}
						//********************************************
						$cash_data[$member_key]['member_id']=$member_row['member_id'];
						$cash_data[$member_key]['user']=$member_row['user'];
						$cash_data[$member_key]['type']="a_bonus";
						$cash_data[$member_key]['cash_currency']=$member_row['day_dividend']+$cash_currency;
						$cash_data[$member_key]['ymd']=$nowYmd;
						$cash_data[$member_key]['y']=$nowY;
						$cash_data[$member_key]['m']=$nowm;
						$cash_data[$member_key]['d']=$nowd;
						$cash_data[$member_key]['ctime']=$nowTime;
						//************************************更新用户表
						$dividend_management[$member_key]['cash_currency']=$member_row['day_dividend']+$cash_currency;
						$dividend_management[$member_key]['free_gold']=$free_gold;
						$dividend_management[$member_key]['member_id']=$member_row['member_id'];
						//************************************

					}
					$this->cron_model->msg('member_array data run time : '. $this->cron_model->runStop(1).' s.');
				}

				if(!empty($bonus_data)) {
					$this->cron_model->runStart(1);
					if ($writeDb) $this->cron_model->batchInsertData('bonus', $bonus_data, $maxRecord);
					$this->cron_model->msg('bonus_data insert time : '. $this->cron_model->runStop(1).' s.');
				}
				if ($debugTest) $this->cron_model->test($free_stock_list_a, 'bonus_data', $bonus_data);

				// 统计 bonus_data 值
				$tmpSum = ARRAY();
				foreach ($bonus_data as $key => $val) {
					if (!isset($tmpSum[$val['member_id']])) {
						$tmpSum[$val['member_id']]['sum'] = 0;
						$tmpSum[$val['member_id']]['i'] = 0;
					}
					$tmpSum[$val['member_id']]['sum'] += $val['dividend'];
					$tmpSum[$val['member_id']]['i'] += 1;
				}
				foreach ($tmpSum as $key => $val) {
					$lbl_sum = $key;
					if (!isset($free_stock_list_sum[$lbl_sum]['bonus_data'])) $free_stock_list_sum[$lbl_sum]['bonus_data'] = 0;
					$free_stock_list_sum[$lbl_sum]['bonus_data'] += $val['sum'];
					$free_stock_list_sum[$lbl_sum]['bonus_data_i'] = $val['i'];
				}				

				if(!empty($data_dividend)) {
					$this->cron_model->runStart(1);
					if ($writeDb) $this->cron_model->batchUpdateData('free_stock', $data_dividend,'free_stock_id', $maxRecord);
					$this->cron_model->msg('data_dividend update time : '. $this->cron_model->runStop(1).' s.');
				}

				if(!empty($management_data)) {
					$this->cron_model->runStart(1);
					if ($writeDb) $this->cron_model->batchInsertData('management', $management_data, $maxRecord);
					$this->cron_model->msg('management_data insert time : '. $this->cron_model->runStop(1).' s.');
				}
				if ($debugTest) $this->cron_model->test($free_stock_list_a, 'management_data', $management_data);

				if(!empty($cash_data)) {
					$this->cron_model->runStart(1);
					if ($writeDb) $this->cron_model->batchInsertData('cash', $cash_data, $maxRecord);
					$this->cron_model->msg('cash_data insert time : '. $this->cron_model->runStop(1).' s.');
				}
				if ($debugTest) $this->cron_model->test($free_stock_list_a, 'cash_data', $cash_data);

				// 统计 cash_data 值
				$tmpSum = ARRAY();
				foreach ($cash_data as $key => $val) {
					if (!isset($tmpSum[$val['member_id']])) {
						$tmpSum[$val['member_id']]['sum'] = 0;
						$tmpSum[$val['member_id']]['i'] = 0;
					}
					$tmpSum[$val['member_id']]['sum'] += $val['cash_currency'];
					$tmpSum[$val['member_id']]['i'] += 1;
				}
				foreach ($tmpSum as $key => $val) {
					$lbl_sum = $key;
					if (!isset($free_stock_list_sum[$lbl_sum]['cash_data'])) $free_stock_list_sum[$lbl_sum]['cash_data'] = 0;

					$free_stock_list_sum[$lbl_sum]['cash_data'] += $val['sum'];
					$free_stock_list_sum[$lbl_sum]['cash_data_i'] = $val['i'];
				}

				if(!empty($free_gold_data)) {
					$this->cron_model->runStart(1);
					if ($writeDb) $this->cron_model->batchInsertData('free_gold', $free_gold_data, $maxRecord);
					$this->cron_model->msg('free_gold_data insert time : '. $this->cron_model->runStop(1).' s.');
				}
				if ($debugTest) $this->cron_model->test($free_stock_list_a, 'free_gold_data', $free_gold_data);

				if(!empty($dividend_data)) {
					$this->cron_model->runStart(1);
					if ($writeDb) $this->cron_model->batchInsertData('dividend', $dividend_data, $maxRecord);
					$this->cron_model->msg('dividend_data insert time : '. $this->cron_model->runStop(1).' s.');
				}
				if ($debugTest) $this->cron_model->test($free_stock_list_a, 'dividend_data', $dividend_data);

				// 统计 dividend_data 值
				$tmpSum = ARRAY();
				foreach ($dividend_data as $key => $val) {
					if (!isset($tmpSum[$val['member_id']])) {
						$tmpSum[$val['member_id']]['sum'] = 0;
						$tmpSum[$val['member_id']]['i'] = 0;
					}
					$tmpSum[$val['member_id']]['sum'] += $val['day_dividend'];
					$tmpSum[$val['member_id']]['i'] += 1;
				}
				foreach ($tmpSum as $key => $val) {
					$lbl_sum = $key;
					if (!isset($free_stock_list_sum[$lbl_sum]['dividend_data'])) $free_stock_list_sum[$lbl_sum]['dividend_data'] = 0;

					$free_stock_list_sum[$lbl_sum]['dividend_data'] += $val['sum'];
					$free_stock_list_sum[$lbl_sum]['dividend_data_i'] = $val['i'];
				}

				if(!empty($dividend_management)) {
					$this->cron_model->runStart(1);
					if ($writeDb) $this->member_model->add_management_batch($dividend_management,'member_id');
					$this->cron_model->msg('dividend_management insert time : '. $this->cron_model->runStop(1).' s.');
					// $this->cron_model->msg('$this->member_model->add_management_batch :'. $this->db->last_query());
				}

				$this->cron_model->runStart(1);
				if ($writeDb) $this->management_day_model->update_date(end($member_id_array),$nowYmd);
				$this->cron_model->msg('member_id_array update time : '. $this->cron_model->runStop(1).' s.');
				// $this->cron_model->msg('$this->management_day_model->update_date :'. $this->db->last_query());

				$this->cron_model->runStart(1);
				if ($writeDb) $this->a_bonus_model->end($all_dividend,$all_management,$a_bonus_id);
				$this->cron_model->msg('all_dividend && all_management update time : '. $this->cron_model->runStop(1).' s.');
				$this->cron_model->msg('total run time : '.$this->cron_model->runStop().' s.', TRUE);

			} else{
				$this->cron_model->msg('Suspend the presentation today.', TRUE);
			}

		} else {
			$this->cron_model->msg('Need to run in CLI mode.', TRUE);
		}
		$this->cron_model->msg('', TRUE);
		$this->cron_model->msg('--- '. date("Y-m-d H:i:s") .' ---', TRUE);
		exit(0);

	}

	public function me() {
		echo 'test ok.';
		exit(0);
	}
}

/* End of file cron.php */
/* Location: ./application/controllers/cron.php */
