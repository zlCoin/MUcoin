<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sell_cash_currency extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
 		fun_check_password2();
    }
	public function index($page=1,$parameter="")
	{
		$html=$this->init("出售现金积分","jquery,login");
		$id=$this->login_lib->member_id();
		$this->load->model('member_model');
		$html['row']=$this->member_model->get_row_byid($id);
		if($html['row']->collection_bank=="" || $html['row']->bank_name=="" || $html['row']->account=="" || $html['row']->bank==""  || $html['row']->province==""  || $html['row']->city==""){
					$this->session->set_flashdata('error_show', '完善银行帐号信息后才能挂单');
					redirect("bank_account");
		}
		$html['collection_mode']=fun_collection_mode();
		$this->load->model('cash_currency_market_model');
		$html['cash_currency_market_count']=$this->cash_currency_market_model->check_buyer_number($id);
		$html['cash_currency_market_state_count']=$this->cash_currency_market_model->check_state_count_bymember_id($id);
		//echo $this->db->last_query();
		$this->load->model('area_model');
		$html['province']=$this->area_model->get_area_byid(1);
		if($html['row']->city!="")
			$html['city']=$this->area_model->get_area_byid($html['row']->province);
		else
			$html['city']="";
		$this->load->view('/sell_cash_currency',$html);
	}
	public function sell_submit(){
		$this->load->model('member_model');		
		$id=$this->login_lib->member_id();
		$member=$this->member_model->get_row_byid($id);
		$number=$this->input->post('number');
		$poundage=$this->input->post('poundage');
		
		if (!$this->check_user_have_shop($member->user))
		{
			$this->session->set_flashdata("error_show", "挂单失败,请先成为神州生活空间商家后挂单!");
			
			redirect("sell_cash_currency");
		}
		
		if($member->cash_currency>=$number){//+$poundage
			$return_result=$this->member_model->minus_cash($number,$id);//+$poundage
			if($return_result>0){		
				$this->load->model('cash_currency_market_model');
				$data['member_id']=$id;
				$data['user']=$this->input->post('user');
				$data['mobile']=$this->input->post('mobile');
				$data['collection_bank']=$this->input->post('collection_bank');
				$data['bank']=$this->input->post('bank');
				$data['account']=$this->input->post('account');
				$data['name']=$this->input->post('name');
				$data['province']=my_area_name($this->input->post('province'));
				$data['city']=my_area_name($this->input->post('city'));
				$data['number']=$number;
				$data['poundage']=$poundage;
				$data['ymd']=date("Ymd");	
				$data['y']=date("Y");		
				$data['m']=date("m");		
				$data['d']=date("d");	
				$return_result=$this->cash_currency_market_model->add($data);
				if($return_result>0){
					$this->session->set_flashdata('success_show', '挂单成功');
					redirect("sell_cash_currency");
				}else{
					$this->session->set_flashdata('error_show', '挂单失败');
					redirect("sell_cash_currency");
				}	
			}else{
				$this->session->set_flashdata('error_show', '挂单失败');
				redirect("sell_cash_currency");
			}
		}else{
			$this->session->set_flashdata('error_show', '现金积分不足挂单失败');
			redirect("sell_cash_currency");
		}
	}
	
	public function  check_user_have_shop($user_name){
		$sql="select * from ecs_users where user_name='". $user_name . "'; ";		
		
		$query = $this->db->query($sql);
		$row = $query->row();

		if (isset($row))
		{			
			$sql_supplier="select * from ecs_supplier where user_id=" . $row->user_id .";";
			
			$query = $this->db->query($sql_supplier);
			$row = $query->row();
			if (isset($row))
			{	
				if ($row->status == 1)
				{
					return true;
				}
			}
			
			return false;
		}
		else
		{
			return false;
			
		}
	}
	
}

/* End of file sell_cash_currency.php */
/* Location: ./application/controllers/sell_cash_currency.php */