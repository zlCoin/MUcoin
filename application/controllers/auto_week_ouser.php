<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auto_week_ouser extends CI_Controller {

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
		$this->week_model->runStart(1);
		// 必须以 CLI 方式运行
		//if ($this->input->is_cli_request()) {
			$this->week_model->msg('program start run...');
			$w=date("w", $nowTime);//$w=="6" || $w=="0" ||  周六周日不送
			$this->week_model->msg('week time: '.date('Y-m-d H:i:s', $nowTime).', week val: '.$w, TRUE);
			if($w=="1" || $w=="2"  || $w=="3"  || $w=="4"  || $w=="5" ){
				$this->load->model('member_model');//用户表
			/* 不限制读取数量 读取全部 */
				$this->week_model->runStart(1);
           //查询free_stock 循环列表
				$free_stock_list=$this->week_model->get_dividend_member('', '', $nowTime);
				$this->week_model->msg('user number : '.count($free_stock_list), TRUE);
				$this->week_model->msg('get_dividend_member run time : '. $this->week_model->runStop(1).' s.');
				$free_currency_e=array();
				$member_array=array();
				$member_id_array=array();
				$this->week_model->runStart(1);
				foreach($free_stock_list as $key=>$row){

                $tc_price=$this->member_model->get_row_byid($row->member_id);
			    if($tc_price->electronic_currency>0){
                $this->load->model('member_model');
				$this->load->model('dj_free_model');
				//统计一周内 下面会有所有资产
                $count_zc=$this->member_model->get_sums_electronic_currency($row->member_id);
                
				$count_dj=$count_zc[0]['dj_price'];

				//这个3%不用了
				//$member_dj_price_list=$this->dj_free_model->get_sums_dj_price($row->member_id);
				    $count_sums=$count_dj;
					if (intval($count_sums) > 0){
						//取业绩的30% 存入资产钱包

						$add_dj_price=$count_sums*0.2;

                        echo "add_dj_price==".$add_dj_price."<br>";
						echo "member_id==".$row->member_id."<br>";
						if($add_dj_price>=$tc_price->electronic_currency){

                          $add_dj_price=$tc_price->electronic_currency;
						  $this->member_model->add_dj_price($add_dj_price,$row->member_id);
                         //同时减少原始积分
						 //echo $this->db->last_query();echo "<br/>";
						  $this->member_model->minus_electronic($add_dj_price,$row->member_id,0);
                         
						}else{
						  $this->member_model->add_dj_price($add_dj_price,$row->member_id);
                         //同时减少原始积分
						  $this->member_model->minus_electronic($add_dj_price,$row->member_id,0);
						}

                     if(!$this->dj_free_model->get_sums_dj_price($row->member_id))
						{
                          $free_currency['member_id']=$row->member_id;
                          $free_currency['price']=$add_dj_price*0.03;
   						  $free_currency['ctime']=$nowTime;
                          $this->dj_free_model->add_dj_list($free_currency);
						  echo $this->db->last_query()."<br>";
						}else{
                           $free_currencyt=$add_dj_price*0.03;
					  $this->dj_free_model->update_dj_list($free_currencyt,$row->member_id);
						 echo $this->db->last_query()."<br>";
						}

					 }
				}
			}
 
		   unset($free_stock_list);
		}
			 $this->week_model->msg('total run time : '.$this->week_model->runStop().' s.', TRUE);
		//} else {
		//	$this->week_model->msg('Need to run in CLI mode.', TRUE);
		//}
		$this->week_model->msg('', TRUE);
		$this->week_model->msg('--- '. date("Y-m-d H:i:s") .' ---', TRUE);
		exit(0);
	}
}
/* End of file auto_week_ouser.php */
/* Location: ./application/controllers/auto_week_ouser.php */