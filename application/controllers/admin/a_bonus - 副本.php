<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class A_bonus extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
    }
	public function index() {
		$html=$this->admin_init("开始分红","jquery,login,validate");		
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
		//	echo $this->db->last_query();
		$this->load->model('bonus_model');
		$html['bonus_count']=$this->bonus_model->get_row_byymd_count();

		$this->load->model('system_switch_model');
		$html['system_switch']=$this->system_switch_model->get_row_byid(1);	
		$this->load->model('management_day_model');
		$management_member_row=$this->management_day_model->get_member_id_byymd(date("Ymd"));
		if(empty($management_member_row)){
			$this->management_day_model->add_ymd(date("Ymd"));
		}
		$this->load->view('/admin/a_bonus',$html);
	}
	public function a_bonus_submit($a_bonus_id){
		set_time_limit(0);
		$this->load->model('a_bonus_model');
		$this->load->model('system_switch_model');
		$system_switch=$this->system_switch_model->get_row_byid(1);
		if($system_switch->day_dividend==0){
			header("Content-type: text/html; charset=utf-8");
			echo "系统暂停分红";die();
		}
		$this->load->model('system_set_model');
		$system_set=$this->system_set_model->get_row_byid(1);
		//date("Ymd",strtotime("-1 day"));
		$w=date("w");
		if($w=="6" || $w=="0" || $w=="1" || $w=="2"  || $w=="3"  || $w=="4"  || $w=="5"){				
				$dividend=0;
				$management=0;
				$this->load->model('free_stock_model');
				//$free_stock_count=$this->free_stock_model->get_day_dividend_count($system_set->dividend_time);
				 $this->load->model('bonus_model');
				 $this->load->model('management_model');				 				
				 $this->load->model('member_model');
				 $this->load->model('cash_model');
				 $this->load->model('free_gold_model');
				 $this->load->model('dividend_model');
				// $this->load->model('management_day_model');
				/*$management_member_row=$this->management_day_model->get_member_id_byymd(date("Ymd"));
				if(!empty($management_member_row)){
					$management_member_array=explode("-",$management_member_row->member_id);
				}else{
					$management_member_array=array();
				}*/
				// flush();
				// $j=0;
				 for($i=0;$i<10;$i++){	
					 
					$free_stock_list=$this->free_stock_model->get_dividend_member($system_set->dividend_time,"1000,0");
		//		echo $this->db->last_query();echo "<br/>";die();
					$bonus_data=array();
					$dividend_management=array();
					$data_dividend=array();			
					$management_data=array();
					$cash_data=array();
					$free_gold_data=array();
					$dividend_data=array();
					foreach($free_stock_list as $key=>$row){
						
						$bonus_data[$key]['member_id']=$row->member_id;
						$bonus_data[$key]['user']=$row->user;
						$bonus_data[$key]['dividend']=$row->day_dividend;
						$bonus_data[$key]['management']=fun_get_member_management_bonus($row->member_id,$row->parent_id_count,trim($row->clue),$row->level,$system_set->cap_amount);	
						//	echo $this->db->last_query();echo "<br/>";
						$bonus_data[$key]['ymd']=date("Ymd");
						$bonus_data[$key]['y']=date("Y");
						$bonus_data[$key]['m']=date("m");
						$bonus_data[$key]['d']=date("d");
						$bonus_data[$key]['ctime']=time();
						
						$cash_currency=$bonus_data[$key]['management']*0.7;
						$free_gold=$bonus_data[$key]['management']*0.3;
						//************************************
						$dividend_management[$key]['cash_currency']=$cash_currency;
						$dividend_management[$key]['free_gold']=$free_gold;
						$dividend_management[$key]['member_id']=$row->member_id;
						
						//************************************
						//************************************
						$data_dividend[$key]["cumulative_dividend"]=$row->cumulative_dividend+$cash_currency+$bonus_data[$key]['dividend'];
						$data_dividend[$key]["ymd"]=date("Ymd");
						$data_dividend[$key]["time"]=$row->time+1;
						if($row->time+1>=$system_set->dividend_time)
							$data_dividend[$key]["state"]=1;
						$data_dividend[$key]["member_id"]=$row->member_id;
						//*************************************
						if($bonus_data[$key]['management']>0){
							$management_data[$key]['member_id']=$row->member_id;
							$management_data[$key]['money']=$bonus_data[$key]['management'];
							$management_data[$key]['cash']=$cash_currency;
							$management_data[$key]['free_gold']=$free_gold;
							$management_data[$key]['ymd']=date("Ymd");
							$management_data[$key]['y']=date("Y");
							$management_data[$key]['m']=date("m");
							$management_data[$key]['d']=date("d");
							$management_data[$key]['ctime']=time();
							//echo $this->db->last_query();echo "<br/>";
						}
						
						
						$cash_data[$key]['member_id']=$row->member_id;					
						$cash_data[$key]['user']=$row->user;				
						$cash_data[$key]['type']="a_bonus";				
						$cash_data[$key]['cash_currency']=$row->day_dividend+$cash_currency;		
						$cash_data[$key]['ymd']=date("Ymd");	
						$cash_data[$key]['y']=date("Y");		
						$cash_data[$key]['m']=date("m");		
						$cash_data[$key]['d']=date("d");
						$cash_data[$key]['ctime']=time();
						
						if($free_gold>0){
							$free_gold_data[$key]['member_id']=$row->member_id;					
							$free_gold_data[$key]['user']=$row->user;				
							$free_gold_data[$key]['type']="a_bonus";				
							$free_gold_data[$key]['free_gold']=$free_gold;		
							$free_gold_data[$key]['ymd']=date("Ymd");	
							$free_gold_data[$key]['y']=date("Y");		
							$free_gold_data[$key]['m']=date("m");		
							$free_gold_data[$key]['d']=date("d");	
							$free_gold_data[$key]['ctime']=time();
						}
						
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
						
						$dividend+=$bonus_data[$key]['dividend'];
						$management+=$bonus_data[$key]['management'];
					//	$j++;
					}
					unset($free_stock_list);
					
					if(!empty($bonus_data))
						$this->bonus_model->add_batch($bonus_data);
					if(!empty($data_dividend))
						$this->free_stock_model->update_data_batch($data_dividend,'member_id');
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
					//echo $this->db->last_query();echo "<br/>";
					//print_r($bonus_data);
				//	die();
					//flush(); 
					//sleep(1);
				}				
			//	$this->management_day_model->update_date(implode('-',array_filter($management_member_array)),date("Ymd"));
			//	if($j>=$count){
					//$a_bonus_data['state']=1;
					echo "OK";
			//	}else{
				//	echo "Continue";
				//}
				$this->a_bonus_model->end($dividend,$management,$a_bonus_id);				
				die();
		}else{
			
			header("Content-type: text/html; charset=utf-8");
			echo "今天暂停分红";die();
		}
//	redirect("admin/a_bonus_record");
	}	
}

/* End of file a_bonus.php */
/* Location: ./application/controllers/admin/a_bonus.php */