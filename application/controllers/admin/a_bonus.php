<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class A_bonus extends CI_Controller {


	function __construct()
    {
        parent::__construct();
    }
	public function index() {
		$html=$this->admin_init("开始积分赠送","jquery,login,validate");
		$this->load->model('a_bonus_model');
		$a_bonus=$this->a_bonus_model->get_row_byymd();
		if(!empty($a_bonus)==0){
			$html['a_bonus_id']=$this->a_bonus_model->start();
			$html['state']=0;
		}else{
			$html['a_bonus_id']=$a_bonus->a_bonus_id;
			$html['state']=$a_bonus->state;
		}
		$this->load->model('system_set_model');
		$system_set=$this->system_set_model->get_row_byid(1);
		$this->load->model('free_stock_model');
		$html['free_stock_count']=$this->free_stock_model->get_day_dividend_count($system_set->dividend_time);
		$this->load->model('bonus_model');
		$html['bonus_count']=$this->bonus_model->get_row_byymd_count();

		$this->load->model('system_switch_model');
		$html['system_switch']=$this->system_switch_model->get_row_byid(1);
		$this->free_stock_model->update_repair_data();
		$this->load->model('management_day_model');
		$management_member_row=$this->management_day_model->get_member_id_byymd(date("Ymd"));
		if(empty($management_member_row)){
			$this->management_day_model->add_ymd(date("Ymd"));
		}
		$this->load->view('/admin/a_bonus',$html);
	}
	public function member() {
		$html=$this->admin_init("开始积分赠送","jquery,login,validate,date");
		$this->load->view('/admin/a_bonus_member',$html);
	}
	public function member_submit(){
		set_time_limit(0);
		header("Content-type: text/html; charset=utf-8");
		$this->load->model('member_model');
		$user=trim($this->input->post('user'));
		$ymd=trim($this->input->post('ymd'));
		if($user==""){
			echo "帐号不能为空";die();
		}
		$member=$this->member_model->get_row_byuser($user);
		echo "积分赠送会员：".$member->user;echo "<br/>";
		$this->load->model('system_switch_model');
		$system_switch=$this->system_switch_model->get_row_byid(1);
      
		if($system_switch->day_dividend==0){
			echo "系统暂停积分赠送";die();
		}

		$this->load->model('system_set_model');
		$system_set=$this->system_set_model->get_row_byid(1);
 
		$w=date("w");//$w=="6" || $w=="0" ||
		if($w=="1" || $w=="2"  || $w=="3"  || $w=="4"  || $w=="5"){
				$dividend=0;
				$management=0;
				$this->load->model('free_stock_model');
				 $this->load->model('bonus_model');
				 $this->load->model('management_model');
				 $this->load->model('member_model');
				 $this->load->model('cash_model');
				 $this->load->model('free_gold_model');
				 $this->load->model('dividend_model');
				$free_stock_list=$this->free_stock_model->get_dividend_member_bymember_id($system_set->dividend_time,$member->member_id,$ymd);
				echo "积分赠送数据：";
				print_r($free_stock_list);echo "<br/>";
				//echo $this->db->last_query();echo "<br/>";die();
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
				foreach($free_stock_list as $key=>$row){
					$bonus_data[$key]['member_id']=$row->member_id;
					$bonus_data[$key]['user']=$row->user;
					$bonus_data[$key]['dividend']=$row->day_dividend;
					$bonus_data[$key]['management']=0;
					$bonus_data[$key]['ymd']=date("Ymd");
					$bonus_data[$key]['y']=date("Y");
					$bonus_data[$key]['m']=date("m");
					$bonus_data[$key]['d']=date("d");
					$bonus_data[$key]['ctime']=time();

					//************************************更新自由股表
					$data_dividend[$key]["cumulative_dividend"]=$row->cumulative_dividend+$bonus_data[$key]['dividend'];
					$data_dividend[$key]["ymd"]=date("Ymd");
					$data_dividend[$key]["time"]=$row->time+1;
					if($row->time+1>=$system_set->dividend_time)
						$data_dividend[$key]["state"]=1;
					$data_dividend[$key]["free_stock_id"]=$row->free_stock_id;
					//*************************************
					$dividend_data[$key]['member_id']=$row->member_id;
					$dividend_data[$key]['user']=$row->user;
					$dividend_data[$key]['no']=$row->no;
					$dividend_data[$key]['number']=$row->number;
					$dividend_data[$key]['day_dividend']=$row->day_dividend;
					$dividend_data[$key]['time']=$row->time+1;
					$dividend_data[$key]['cumulative_dividend']=$row->cumulative_dividend+$row->day_dividend;
					$dividend_data[$key]['btime']=$row->ctime;
					$dividend_data[$key]['ymd']=date("Ymd");
					$dividend_data[$key]['y']=date("Y");
					$dividend_data[$key]['m']=date("m");
					$dividend_data[$key]['d']=date("d");
					$dividend_data[$key]['ctime']=time();
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
				$all_management=0;
				if(!empty($member_array)){
					foreach($member_array  as $member_key=>$member_row){
						$management=fun_get_member_management_bonus($member_row['member_id'],10,$member_row['clue'],$member_row['level'],$system_set->cap_amount,$system_set->dividend_time);
						echo "管理奖：";
						echo $management;echo "<br/>";
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
								$management_data[$member_key]['ymd']=date("Ymd");
								$management_data[$member_key]['y']=date("Y");
								$management_data[$member_key]['m']=date("m");
								$management_data[$member_key]['d']=date("d");
								$management_data[$member_key]['ctime']=time();
								//echo $this->db->last_query();echo "<br/>";

								if($free_gold>0){
									$free_gold_data[$member_key]['member_id']=$member_row['member_id'];
									$free_gold_data[$member_key]['user']=$member_row['user'];
									$free_gold_data[$member_key]['type']="a_bonus";
									$free_gold_data[$member_key]['free_gold']=$free_gold;
									$free_gold_data[$member_key]['ymd']=date("Ymd");
									$free_gold_data[$member_key]['y']=date("Y");
									$free_gold_data[$member_key]['m']=date("m");
									$free_gold_data[$member_key]['d']=date("d");
									$free_gold_data[$member_key]['ctime']=time();
								}

								$all_management+=$management;

						}
						//********************************************
						$cash_data[$member_key]['member_id']=$member_row['member_id'];
						$cash_data[$member_key]['user']=$member_row['user'];
						$cash_data[$member_key]['type']="a_bonus";
						$cash_data[$member_key]['cash_currency']=$member_row['day_dividend']+$cash_currency;
						$cash_data[$member_key]['ymd']=date("Ymd");
						$cash_data[$member_key]['y']=date("Y");
						$cash_data[$member_key]['m']=date("m");
						$cash_data[$member_key]['d']=date("d");
						$cash_data[$member_key]['ctime']=time();
						//************************************更新用户表
						$dividend_management[$member_key]['cash_currency']=$member_row['day_dividend']+$cash_currency;
						$dividend_management[$member_key]['free_gold']=$free_gold;
						$dividend_management[$member_key]['member_id']=$member_row['member_id'];
						//************************************
					}
					/*if(!empty($bonus_data))
						$this->bonus_model->add_batch($bonus_data);
					if(!empty($data_dividend))
						$this->free_stock_model->update_data_batch($data_dividend,'free_stock_id');
					if(!empty($management_data))
						$this->management_model->add_batch($management_data);
					if(!empty($cash_data))
						$this->cash_model->add_batch($cash_data);
					if(!empty($free_gold_data))
						$this->free_gold_model->add_batch($free_gold_data);
					if(!empty($dividend_data))
						$this->dividend_model->add_batch($dividend_data);
					if(!empty($dividend_management))
						$this->member_model->add_management_batch($dividend_management,'member_id');	*/
					//echo $this->db->last_query();echo "<br/>";
				}
				echo "OK";
				die();
		}else{
			echo "今天暂停积分赠送";die();
		}
	}
	public function a_bonus_submit($a_bonus_id){
		set_time_limit(0);
		$this->load->model('a_bonus_model');
		$this->load->model('system_switch_model');
		$system_switch=$this->system_switch_model->get_row_byid(1);
		if($system_switch->day_dividend==0){
			header("Content-type: text/html; charset=utf-8");
			echo "系统暂停积分赠送";die();
		}
		$this->load->model('system_set_model');
		$system_set=$this->system_set_model->get_row_byid(1);
		$w=date("w");//$w=="6" || $w=="0" ||
		if($w=="1" || $w=="2"  || $w=="3"  || $w=="4"  || $w=="5"){
				$dividend=0;
				$management=0;
				$this->load->model('free_stock_model');
				 $this->load->model('bonus_model');
				 $this->load->model('management_model');
				 $this->load->model('member_model');
				 $this->load->model('cash_model');
				 $this->load->model('free_gold_model');
				 $this->load->model('dividend_model');
				 $this->load->model('management_day_model');
				 for($i=0;$i<10;$i++){
					$free_stock_list=$this->free_stock_model->get_dividend_member($system_set->dividend_time,"1000,0");
					//print_r($free_stock_list);die();
					//echo $this->db->last_query();echo "<br/>";die();
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
					foreach($free_stock_list as $key=>$row){
						$bonus_data[$key]['member_id']=$row->member_id;
						$bonus_data[$key]['user']=$row->user;
						$bonus_data[$key]['dividend']=$row->day_dividend;
						$bonus_data[$key]['management']=0;
						$bonus_data[$key]['ymd']=date("Ymd");
						$bonus_data[$key]['y']=date("Y");
						$bonus_data[$key]['m']=date("m");
						$bonus_data[$key]['d']=date("d");
						$bonus_data[$key]['ctime']=time();

						//************************************更新自由股表
						$data_dividend[$key]["cumulative_dividend"]=$row->cumulative_dividend+$bonus_data[$key]['dividend'];
						$data_dividend[$key]["ymd"]=date("Ymd");
						$data_dividend[$key]["time"]=$row->time+1;
						if($row->time+1>=$system_set->dividend_time)
							$data_dividend[$key]["state"]=1;
						$data_dividend[$key]["free_stock_id"]=$row->free_stock_id;
						//*************************************
						$dividend_data[$key]['member_id']=$row->member_id;
						$dividend_data[$key]['user']=$row->user;
						$dividend_data[$key]['no']=$row->no;
						$dividend_data[$key]['number']=$row->number;
						$dividend_data[$key]['day_dividend']=$row->day_dividend;
						$dividend_data[$key]['time']=$row->time+1;
						$dividend_data[$key]['cumulative_dividend']=$row->cumulative_dividend+$row->day_dividend;
						$dividend_data[$key]['btime']=$row->ctime;
						$dividend_data[$key]['ymd']=date("Ymd");
						$dividend_data[$key]['y']=date("Y");
						$dividend_data[$key]['m']=date("m");
						$dividend_data[$key]['d']=date("d");
						$dividend_data[$key]['ctime']=time();
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
					$all_management=0;
					if(!empty($member_array)){
						$management_member_row=$this->management_day_model->get_member_id_byymd(date("Ymd"));
						if(isset($member_array[$management_member_row->member_id])){
							$this->cash_model->update_cash_currency_byymd($member_array[$management_member_row->member_id]['day_dividend'],$management_member_row->member_id);
							$this->member_model->add_cash($member_array[$management_member_row->member_id]['day_dividend'],$management_member_row->member_id);
							unset($member_array[$management_member_row->member_id]);
						}
						//print_r($member_array);die();
						foreach($member_array  as $member_key=>$member_row){
							$management=fun_get_member_management_bonus($member_row['member_id'],10,$member_row['clue'],$member_row['level'],$system_set->cap_amount,$system_set->dividend_time);
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
									$management_data[$member_key]['ymd']=date("Ymd");
									$management_data[$member_key]['y']=date("Y");
									$management_data[$member_key]['m']=date("m");
									$management_data[$member_key]['d']=date("d");
									$management_data[$member_key]['ctime']=time();
									//echo $this->db->last_query();echo "<br/>";

									if($free_gold>0){
										$free_gold_data[$member_key]['member_id']=$member_row['member_id'];
										$free_gold_data[$member_key]['user']=$member_row['user'];
										$free_gold_data[$member_key]['type']="a_bonus";
										$free_gold_data[$member_key]['free_gold']=$free_gold;
										$free_gold_data[$member_key]['ymd']=date("Ymd");
										$free_gold_data[$member_key]['y']=date("Y");
										$free_gold_data[$member_key]['m']=date("m");
										$free_gold_data[$member_key]['d']=date("d");
										$free_gold_data[$member_key]['ctime']=time();
									}

									$all_management+=$management;

							}
							//********************************************
							$cash_data[$member_key]['member_id']=$member_row['member_id'];
							$cash_data[$member_key]['user']=$member_row['user'];
							$cash_data[$member_key]['type']="a_bonus";
							$cash_data[$member_key]['cash_currency']=$member_row['day_dividend']+$cash_currency;
							$cash_data[$member_key]['ymd']=date("Ymd");
							$cash_data[$member_key]['y']=date("Y");
							$cash_data[$member_key]['m']=date("m");
							$cash_data[$member_key]['d']=date("d");
							$cash_data[$member_key]['ctime']=time();
							//************************************更新用户表
							$dividend_management[$member_key]['cash_currency']=$member_row['day_dividend']+$cash_currency;
							$dividend_management[$member_key]['free_gold']=$free_gold;
							$dividend_management[$member_key]['member_id']=$member_row['member_id'];
							//************************************
						}
					}
					//echo "OK";
				//	die();
					if(!empty($bonus_data))
						$this->bonus_model->add_batch($bonus_data);
					if(!empty($data_dividend))
						$this->free_stock_model->update_data_batch($data_dividend,'free_stock_id');
					if(!empty($management_data))
						$this->management_model->add_batch($management_data);
					if(!empty($cash_data))
						$this->cash_model->add_batch($cash_data);
					if(!empty($free_gold_data))
						$this->free_gold_model->add_batch($free_gold_data);
					if(!empty($dividend_data))
						$this->dividend_model->add_batch($dividend_data);
					if(!empty($dividend_management))
						$this->member_model->add_management_batch($dividend_management,'member_id');
					$this->management_day_model->update_date(end($member_id_array),date("Ymd"));
					//echo $this->db->last_query();echo "<br/>";
				}
				$this->a_bonus_model->end($all_dividend,$all_management,$a_bonus_id);
				echo "OK";
				die();
		}else{
			header("Content-type: text/html; charset=utf-8");
			echo "今天暂停积分赠送";die();
		}
		//	redirect("admin/a_bonus_record");
	}
}

/* End of file a_bonus.php */
/* Location: ./application/controllers/admin/a_bonus.php */