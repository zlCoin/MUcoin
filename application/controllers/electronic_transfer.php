<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Electronic_transfer extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
        fun_check_member_state();	// 限制激活操作
 		fun_check_password2();
    }
	public function index() {
		$html=$this->init("报单积分转帐","jquery,login,validate");
		$id=$this->login_lib->member_id();
		$this->load->model('member_model');
		$html['row']=$this->member_model->get_row_byid($id);
		$this->load->view('/electronic_transfer',$html);
	}
	public function ajax_get_member_name_byuser($operation=""){
		$user=$this->input->post('user');
		$this->load->model('member_model');
		$row=$this->member_model->get_row_byuser($user);
		if(!empty($row))
			echo $row->name;
		else
			echo "";
	}
	public function to_submit()
	{
		$this->load->model('member_model');
		$id=$this->login_lib->member_id();
		$wallet_currency=$this->input->post('wallet_currency');//总积分
		$to_user=trim($this->input->post('to_user'));
		$to_electronic_currency=$this->input->post('to_electronic_currency');//转出积分
		$member2=$this->member_model->get_row_byuser($to_user);
		if(!isset($member2->member_id)){
			$this->session->set_flashdata('error_show', '转给会员不存在');
			redirect("electronic_transfer");
		}
		
		if($id!="" && $wallet_currency>=100 && $to_electronic_currency>=100){
			$member=$this->member_model->get_row_byid($id);
			
			if (!$this->member_model->check_electronic_transfer_touser_have_same_tree($member->user,$member2->user))
			{
				$this->session->set_flashdata('error_show', '系统不允许跨部门转账!');
				redirect("electronic_transfer");
			}
			
			if($member->wallet_currency>=$to_electronic_currency){
				$return_result=$this->member_model->minus_wallet($to_electronic_currency,$member->member_id);
				//echo $this->db->last_query();die();
				if($return_result>0){					
					$this->member_model->add_wallet($to_electronic_currency,$member2->member_id);
					$this->load->model('cash_model');
					$data['member_id']=$member->member_id;		
					$data['user']=$member->user;						
					$data['to_member_id']=$member2->member_id;					
					$data['to_user']=$member2->user;				
					$data['to_name']=$member2->name;				
					$data['type']="cash_to_cash";				
					$data['transfer']=0;
					$data['remark']="报单积分转出".$to_electronic_currency;
					$data['cash_currency']=$to_electronic_currency;		
					//$data['to_electronic_currency']=$to_electronic_currency;	
					$data['ymd']=date("Ymd");	
					$data['y']=date("Y");		
					$data['m']=date("m");		
					$data['d']=date("d");						
					$return_result=$this->cash_model->add($data);

					$data2['member_id']=$member2->member_id;		
					$data2['user']=$member2->user;						
					$data2['from_member_id']=$member->member_id;				
					$data2['from_user']=$member->user;						
					$data2['from_name']=$member->name;			
					$data2['type']="cash_to_cash";				
					$data2['transfer']=1;
					$data['remark']="报单积分转入".$to_electronic_currency;
					$data2['cash_currency']=$to_electronic_currency;		
 					$data2['ymd']=date("Ymd");	
					$data2['y']=date("Y");		
					$data2['m']=date("m");		
					$data2['d']=date("d");	
					$return_result=$this->cash_model->add($data2);
					if($return_result>0){
						$this->session->set_flashdata('success_show', '报单积分转帐成功');
						redirect("electronic_transfer");
					}else{
						$this->session->set_flashdata('error_show', '报单积分转帐失败');
						redirect("electronic_transfer");
					}
				}else{
						$this->session->set_flashdata('error_show', '报单积分转帐失败');
						redirect("electronic_transfer");
					}
			}else{
						$this->session->set_flashdata('error_show', '报单积分不足转帐失败');
						redirect("electronic_transfer");
					}
		}else{
			$this->session->set_flashdata('error_show', '报单积分转帐失败');
						redirect("electronic_transfer");
		}

	}
}

/* End of file electronic_transfer.php */
/* Location: ./application/controllers/electronic_transfer.php */