<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Plan extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
		fun_check_expiration_date2();
    }
	public function index($page=1,$parameter="")
	{
		$html=$this->init("保本计划","jquery,login");		
		$id=$this->login_lib->member_id();
		$this->load->model('member_model');
		$html['row']=$this->member_model->get_row_byid($id);
		$this->load->model('free_stock_model');		
		$html['max']= $this->free_stock_model->max_number_bymember_id($id);
		$this->load->model('plan_model');		
		$html['plan']= $this->plan_model->plan_count_bymember_id($id);
		$html['time']=mktime(0,0,0,2016,01,01);
		$this->load->view('/plan_list',$html);
	}
	public function exchange($page=1,$parameter="")
	{
		$html=$this->init("积分兑换","jquery,login");		
		$id=$this->login_lib->member_id();
		$this->load->model('member_model');
		$html['row']=$this->member_model->get_row_byid($id);
		$this->load->model('free_stock_model');		
		$html['max']= $this->free_stock_model->max_number_bymember_id($id);
		$this->load->model('area_model');
		$html['province']=$this->area_model->get_area_byid(1);
		$this->load->model('cash_currency_market_model');	
		if($html['row']->city!="")
			$html['city']=$this->area_model->get_area_byid($html['row']->province);
		else
			$html['city']="";		
		$html['cash_currency']= $this->cash_currency_market_model->get_cash_currency_bymember_id($id);
		$html['money']=2600-$html['cash_currency']->number;
		if($html['row']->cash_currency<$html['money']){
			$html['money']=$html['row']->cash_currency;
		}
		$this->load->view('/plan_exchange',$html);
	}
	public function exchange_submit()
	{
		$this->load->model('plan_model');
		$id=$this->login_lib->member_id();
		if($id!=""){
			$money=$this->input->post('money');
		    $this->load->model('member_model');
			$member=$this->member_model->get_row_byid($id);
			if($member->cash_currency>=$money){				
				$data['bank_name']=$this->input->post('bank_name');
				$data['account']=$this->input->post('account');
				$data['bank']=$this->input->post('bank');
				$data['branch_name']=$this->input->post('branch_name');
				$data['province']=my_area_name($this->input->post('province'));
				$data['city']=my_area_name($this->input->post('city'));
				$check_plan=$this->plan_model->check_plan($data['bank_name'],$data['account'],$data['bank'],$data['province'],$data['city']);
				if($check_plan>0){
					$this->session->set_flashdata('error_show', '积分兑换失败银行信息相同');
					redirect("plan/exchange");
				}
				$this->member_model->minus_cash($money,$id);
				$this->load->model('cash_model');
				$cash_data['member_id']=$member->member_id;					
				$cash_data['user']=$member->user;				
				$cash_data['type']="exchange";				
				$cash_data['cash_currency']="-".$money;		
				$cash_data['ymd']=date("Ymd");	
				$cash_data['y']=date("Y");		
				$cash_data['m']=date("m");		
				$cash_data['d']=date("d");	
				$this->cash_model->add($cash_data);
				$data['member_id']=$id;
				$data['user']=$member->user;
				$data['no']=date("Ymdhis").substr(strval($return_result_pay+10000000),1,7);	
				$data['money']=$this->input->post('money');
				$data['ymd']=date("Ymd");	
				$data['y']=date("Y");		
				$data['m']=date("m");		
				$data['d']=date("d");		
				$data['state']=0;
				$return_result=$this->plan_model->add($data);
				if($return_result>0){
					$this->session->set_flashdata('success_show', '积分兑换提交成功');
					redirect("/plan");
				}else{				
					$this->session->set_flashdata('error_show', '积分兑换失败');
					redirect("plan/exchange");
				}
			}else{
				$this->session->set_flashdata('error_show', '现金积分不足兑换失败');
				redirect("plan/exchange");
			}
		}else{
			$this->session->set_flashdata('error_show', '积分兑换失败');
			redirect("plan/exchange");
		}

	}
}

/* End of file plan.php */
/* Location: ./application/controllers/plan.php */