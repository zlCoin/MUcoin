<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auto_week extends CI_Controller {

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
        $this->load->model('week_model');
		$maxRecord = 1000; // 单次最大写入数量
		$this->week_model->setLogShow($debug);

		$this->week_model->runStart();


		$this->week_model->msg('--- '. date("Y-m-d H:i:s") .' ---', TRUE);
		$this->week_model->msg('', TRUE);

		$nowTime = empty($time) ? time() : strtotime($time);

		$nowYmd = date("Ymd", $nowTime);
		$nowY = date("Y", $nowTime);
		$nowm = date("m", $nowTime);
		$nowd = date("d", $nowTime);
        
		$this->week_model->msg('set time : '. date("Y-m-d", $nowTime), TRUE);
		/* 前置判断 查询当前是否已经写入数据 */
		$this->week_model->runStart(1);
		//查询当前时间是否已经有了记录在 a_bonus表
		$a_bonus=$this->week_model->get_row_byymd($nowTime);
		if (empty($a_bonus)) {
		    //如果没有记录 那么就插入数据
			$a_bonus_id=$this->week_model->start($nowTime);
 		} else {
			//否则返回当前ID
			$a_bonus_id=$a_bonus['a_bonus_id'];
		}

		$this->week_model->msg('get_row_byymd run time : '. $this->week_model->runStop(1).' s.');

		$this->week_model->runStart(1);
		$this->load->model('free_stock_model');
        //同步 free_stock   q_member表  expiration_date  lock isnull类型为0
		$this->free_stock_model->update_repair_data();
		$this->week_model->msg('update_repair_data run time : '. $this->week_model->runStop(1).' s.'); 

		// 必须以 CLI 方式运行
		//if ($this->input->is_cli_request()) {
			$this->week_model->msg('program start run...');
			$this->load->model('a_bonus_model');
			$this->load->model('system_switch_model');
			//查询怕配置$system_switch->day_dividend0关闭功能开关
			$system_switch=$this->system_switch_model->get_row_byid(1);
 
			// 为 0 功能关闭
			if($system_switch->day_dividend == 0) {
				//$this->week_model->msg('system integrator pause,program stop.', TRUE);
				// exit(0);
			}
			$this->load->model('system_set_model');
			$system_set=$this->system_set_model->get_row_byid(1);
            //var_dump($system_set->day_dividend);每天赠送静态收益百分比
            // die;

			$w=date("w", $nowTime);//$w=="6" || $w=="0" ||  周六周日不送
			$this->week_model->msg('week time: '.date('Y-m-d H:i:s', $nowTime).', week val: '.$w, TRUE);
			if($w=="1" || $w=="2"  || $w=="3"  || $w=="4"  || $w=="5" ){
				$dividend=0;
				//$management=0;
				$this->load->model('bonus_model');//
				$this->load->model('member_model');//用户表更新
 				//$this->load->model('dividend_model');
               
				/* 不限制读取数量 读取全部 */

				$this->week_model->runStart(1);

                //查询free_stock 循环列表
				$free_stock_list=$this->week_model->get_dividend_member('', '', $nowTime);

				$this->week_model->msg('user number : '.count($free_stock_list), TRUE);
				$this->week_model->msg('get_dividend_member run time : '. $this->week_model->runStop(1).' s.');

				$bonus_data=array();
 				$data_dividend=array();
				$free_currency=array();
				$free_currency_e=array();
				$dividend_data=array();
				$member_array=array();
				$member_id_array=array();
				$all_dividend=0;
				$all_electronic_currency=0;
				$this->week_model->runStart(1);
				$free_stock_list_a = ARRAY();
				$free_stock_list_0 = ARRAY(); // 用于统计 0 人员
				$free_stock_list_sum = ARRAY(); // 统计信息

 
				foreach($free_stock_list as $key=>$row){
                $tc_price=$this->member_model->get_row_byid($row->member_id);
                
					// 用于测试统计
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

					//************************************更新表
					$data_dividend[$key]["cumulative_dividend"]=$row->cumulative_dividend+$bonus_data[$key]['dividend'];
					$data_dividend[$key]["ymd"]=$nowYmd;//更新时间
					$data_dividend[$key]["time"]=$row->time+1;//次数加1
                
					if($data_dividend[$key]["cumulative_dividend"]>=$tc_price->dj_price){  //是否超过送的是否超过总的
					$data_dividend[$key]["state"]=1;
					$data_dividend[$key]["lock"]=1;
					$data_dividend[$key]["dtime"]=time();
					}
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
				$this->week_model->msg('free_stock_list data run time : '. $this->week_model->runStop(1).' s.');

				$all_management=0;

				if(!empty($member_array)){
 
					$countI = 0;
					$this->week_model->runStart(1);
					foreach($member_array  as $member_key=>$member_row){
 						 
						$free_currencyt=$row->day_dividend;
						$free_currency[$member_key]['member_id']=$member_row['member_id'];
						$free_currency[$member_key]['user']=$member_row['user'];

                         $this->load->model('dj_free_model');
				          $dj_price_list=$this->dj_free_model->get_row_byid($member_row['member_id']);
                            echo $this->db->last_query()."<br>";
                             echo $row->member_id."<br>";

                        if($dj_price_list){

							$free_currency[$member_key]['free_currency']=$dj_price_list->price;
							$free_currency[$member_key]['type']="old_a_bonus";
						}else{
							$free_currency[$member_key]['free_currency']=$row->day_dividend;
							$free_currency[$member_key]['type']="a_bonus";
						}
						$free_currency[$member_key]['ymd']=$nowYmd;
						$free_currency[$member_key]['remark']="静态收益";
						$free_currency[$member_key]['y']=$nowY;
						$free_currency[$member_key]['m']=$nowm;
						$free_currency[$member_key]['d']=$nowd;
						$free_currency[$member_key]['ctime']=$nowTime;
                        
						if($dj_price_list){
						$this->member_model->add_free_currency($dj_price_list->price,$member_row['member_id']);

						$this->member_model->minus_free_currency_dj($dj_price_list->price,$member_row['member_id']);
						}else{
						$this->member_model->add_free_currency($row->day_dividend,$member_row['member_id']);

						$this->member_model->minus_free_currency_dj($row->day_dividend,$member_row['member_id']);
						}
						//echo $this->db->last_query();echo "<br/>";die();
						}
                       $all_management=+$free_currencyt;
					}
					
					$this->week_model->msg('member_array data run time : '. $this->week_model->runStop(1).' s.');
				}

				if(!empty($bonus_data)) {
					$this->week_model->runStart(1);
					if ($writeDb) $this->week_model->batchInsertData('bonus', $bonus_data, $maxRecord);
					$this->week_model->msg('bonus_data insert time : '. $this->week_model->runStop(1).' s.');
				}
				if ($debugTest) $this->week_model->test($free_stock_list_a, 'bonus_data', $bonus_data);
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
					$this->week_model->runStart(1);
					if ($writeDb) $this->week_model->batchUpdateData('free_stock', $data_dividend,'free_stock_id', $maxRecord);
					$this->week_model->msg('data_dividend update time : '. $this->week_model->runStop(1).' s.');
				}
				if(!empty($dividend_data)) {
					$this->week_model->runStart(1);
					if ($writeDb) $this->week_model->batchInsertData('dividend', $dividend_data, $maxRecord);
					$this->week_model->msg('dividend_data insert time : '. $this->week_model->runStop(1).' s.');
				}
				if ($debugTest) $this->week_model->test($free_stock_list_a, 'dividend_data', $dividend_data);

               if(!empty($free_currency)) {
					$this->week_model->runStart(1);
					if ($writeDb) $this->week_model->batchInsertData('free_currency', $free_currency, $maxRecord);
					$this->week_model->msg('free_currency insert time : '. $this->week_model->runStop(1).' s.');
				}
				if ($debugTest) $this->week_model->test($free_stock_list_a, 'dividend_data', $dividend_data);
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

 

				$this->week_model->runStart(1);
				if ($writeDb) $this->a_bonus_model->end($all_dividend,$all_management,$all_electronic_currency,$a_bonus_id);
				$this->week_model->msg('all_dividend && all_management update time : '. $this->week_model->runStop(1).' s.');
			 $this->week_model->msg('total run time : '.$this->week_model->runStop().' s.', TRUE);

			 
		//} else {
		//	$this->week_model->msg('Need to run in CLI mode.', TRUE);
		//}
		$this->week_model->msg('', TRUE);
		$this->week_model->msg('--- '. date("Y-m-d H:i:s") .' ---', TRUE);
		exit(0);

	}
	public function me() {
		echo 'test ok.';
		exit(0);

	}
}

/* End of file cron.php */
/* Location: ./application/controllers/cron.php */
