<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cash_to_electronic extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
 		fun_check_password2();
    }
	public function index() {
		$html=$this->init("现金积分转电子积分","jquery,login,validate");
		$id=$this->login_lib->member_id();
		$this->load->model('member_model');
		$html['row']=$this->member_model->get_row_byid($id);
		$this->load->view('/cash_to_electronic',$html);
	}

	public function to_submit()
	{
		$this->load->model('member_model');
		$id=$this->login_lib->member_id();
		$electronic_currency=$this->input->post('electronic_currency');
		if($id!="" && $electronic_currency>=100){
			$member=$this->member_model->get_row_byid($id);
			if($member->cash_currency>=$electronic_currency && $electronic_currency>=100){
				$return_result=$this->member_model->cash_to_electronic($electronic_currency,$id);
				//echo $this->db->last_query();die();
				if($return_result>0){					
					$this->load->model('cash_model');
					$data['member_id']=$member->member_id;					
					$data['user']=$member->user;				
					$data['type']="cash_to_electronic";				
					$data['cash_currency']="-".$electronic_currency;		
					$data['electronic_currency']=$electronic_currency;	
					$data['ymd']=date("Ymd");	
					$data['y']=date("Y");		
					$data['m']=date("m");		
					$data['d']=date("d");	
					$return_result=$this->cash_model->add($data);
					$this->load->model('electronic_model');
					$electronic_data['member_id']=$member->member_id;		
					$electronic_data['user']=$member->user;					
					$electronic_data['type']="cash_to_electronic";		
					$electronic_data['transfer']=1;	
					$electronic_data['electronic_currency']=$electronic_currency;		
					$electronic_data['ymd']=date("Ymd");	
					$electronic_data['y']=date("Y");		
					$electronic_data['m']=date("m");		
					$electronic_data['d']=date("d");						
					$return_result=$this->electronic_model->add($electronic_data);
					$this->session->set_flashdata('success_show', '现金积分转电子积分成功');
					redirect("cash_to_electronic");
				}else{
					$this->session->set_flashdata('error_show', '现金积分转电子积分失败');
					redirect("cash_to_electronic");
				}
			}else{
					$this->session->set_flashdata('error_show', '现金积分不足转电子积分失败');
					redirect("cash_to_electronic");
			}
		}else{
					$this->session->set_flashdata('error_show', '现金积分转电子积分失败');
					redirect("cash_to_electronic");
		}

	}
}

/* End of file cash_to_electronic.php */
/* Location: ./application/controllers/cash_to_electronic.php */