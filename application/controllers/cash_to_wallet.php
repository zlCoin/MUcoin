<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cash_to_wallet extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
        fun_check_member_state();	// 限制激活操作
 		fun_check_password2();
    }
	public function index() {
		$html=$this->init("奖金积分转报单积分","jquery,login,validate");
		$id=$this->login_lib->member_id();
		$this->load->model('member_model');
		$html['row']=$this->member_model->get_row_byid($id);
		$this->load->view('/cash_to_wallet',$html);
	}

	public function to_submit()
	{
		$this->load->model('member_model');
		$id=$this->login_lib->member_id();
		$wallet_currency=$this->input->post('wallet_currency');
		if($id!="" && $wallet_currency>=100){
			$member=$this->member_model->get_row_byid($id);
			if($member->cash_currency>=$wallet_currency && $wallet_currency>=100){
				$return_result=$this->member_model->cash_to_wallet($wallet_currency,$id);
				//echo $this->db->last_query();die();
				if($return_result>0){					
					$this->load->model('baodan_log_model');
					$data['member_id']=$member->member_id;					
					$data['details_type']=1;				
					$data['type']="cash_to_baodan";	
					$data['currency']=$wallet_currency;	
					$data['remarks']="奖金积分(".$wallet_currency.")==转报单积分".$wallet_currency;	
					$return_result=$this->baodan_log_model->add($data);

					$this->load->model('cash_model');
					$cash_data['member_id']=$member->member_id;		
					$cash_data['user']=$member->user;					
					$cash_data['type']="cash_to_wallet";		
					$cash_data['transfer']=0;	
					$cash_data['electronic_currency']=$wallet_currency;		
					$cash_data['remark']="奖金积分(".$wallet_currency.")==转报单积分".$wallet_currency;	
					$cash_data['ymd']=date("Ymd");	
					$cash_data['y']=date("Y");		
					$cash_data['m']=date("m");		
					$cash_data['d']=date("d");
					$return_result=$this->cash_model->add($cash_data);
					$this->session->set_flashdata('success_show', '奖金积分转报单积分成功');
					redirect("cash_to_wallet");
				}else{
					$this->session->set_flashdata('error_show', '奖金积分转报单积分失败');
					redirect("cash_to_wallet");
				}
			}else{
					$this->session->set_flashdata('error_show', '奖金积分转报单积分失败');
					redirect("cash_to_wallet");
			}
		}else{
					$this->session->set_flashdata('error_show', '奖金积分转报单积分失败');
					redirect("cash_to_wallet");
		}

	}
}

/* End of file cash_to_wallet.php */
/* Location: ./application/controllers/cash_to_wallet.php */