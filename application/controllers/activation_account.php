<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Activation_account extends CI_Controller {
	function __construct()
    {
        parent::__construct();
		fun_check_password2();
    }
	public function index($page=1,$parameter="")
	{
		$html=$this->init("激活账户-电子协议","jquery,login,validate");			
		$id=$this->login_lib->member_id();
		$this->load->model('member_model');
		$html['row']=$this->member_model->get_row_byid($id);
		
		$this->load->model('system_set_model');
		$html['system_set']=$this->system_set_model->get_row_byid(1);
		if($html['row']->state==0){
			$this->load->view('/activation_account_agreement',$html);
		}else{
			$this->load->view('/activation_account',$html);
		}
	}

	public function activation($page=1,$parameter="")
	{
		$html=$this->init("激活账户","jquery,login,validate");			
		$id=$this->login_lib->member_id();
		$this->load->model('member_model');
		$html['row']=$this->member_model->get_row_byid($id);
		
		$this->load->model('system_set_model');
		$html['system_set']=$this->system_set_model->get_row_byid(1);
		$html['success']=$this->session->flashdata('success_show');
		$html['error']=$this->session->flashdata('error_show');
		$this->load->view('/activation_account',$html);
	}
	public function activation_submit()
	{
		$this->load->model('member_model');
		$id=$this->login_lib->member_id();
		$member=$this->member_model->get_row_byid($id);
		$this->load->model('system_set_model');
		$system_set=$this->system_set_model->get_row_byid(1);

         var_dump($system_set);
		 die;



		if($member->electronic_currency>=$system_set->invest_limit){
				$return_result=$this->member_model->minus_electronic($system_set->invest_limit,$id,1);

               




				$data['free_stock']=1;
				$data['state']=1;
				$data['atime']=time();
				$return_result=$this->member_model->update_data($data,$id);
				if($return_result>0){			
						$this->load->model('free_stock_model');
						$free_stock_data['member_id']=$member->member_id;
						$free_stock_data['parent_id_count']=$this->member_model->check_user_byparent_id_count($member->member_id);
						$free_stock_data['user']=$member->user;
						$free_stock_data['clue']=$member->key;
						$free_stock_data['level']=$member->level;
						$free_stock_data['no']=date('Ymdhis').rand(1000,9999);
						$free_stock_data['number']=1;					
						$free_stock_data['day_dividend']=$free_stock_data['number']*$system_set->day_dividend;






						$free_stock_data['expiration_date']=$member->expiration_date;
						$this->free_stock_model->add($free_stock_data);
						if($member->parent_id>0 || $member->parent_user!=""){							
							$member2=$this->member_model->get_row_byid($member->parent_id);
							$this->member_model->add_cash($system_set->bonus,$member->parent_id);
							$this->load->model('cash_model');
							$cash_data['member_id']=$member2->member_id;					
							$cash_data['user']=$member2->user;
							$cash_data['from_member_id']=$member->member_id;		
							$cash_data['from_user']=$member->user;			
							$cash_data['type']="recommend";				
							$cash_data['cash_currency']=$system_set->bonus;
							$cash_data['ymd']=date("Ymd");	
							$cash_data['y']=date("Y");		
							$cash_data['m']=date("m");		
							$cash_data['d']=date("d");	
							$this->cash_model->add($cash_data);
							$this->load->model('recommend_model');
							$recommend_data['member_id']=$member->parent_id;		
							$recommend_data['user']=$member2->user;
							$recommend_data['from_member_id']=$member->member_id;		
							$recommend_data['from_user']=$member->user;				
							$recommend_data['money']=$system_set->bonus;		
							$recommend_data['atime']=$data['atime'];	
							$recommend_data['ymd']=date("Ymd");	
							$recommend_data['y']=date("Y");		
							$recommend_data['m']=date("m");		
							$recommend_data['d']=date("d");						
							$this->recommend_model->add($recommend_data);
						}
						$this->load->model('electronic_model');
						$electronic_data['member_id']=$member->member_id;		
						$electronic_data['user']=$member->user;					
						$electronic_data['type']="electronic_activation";			
						$electronic_data['electronic_currency']=$system_set->invest_limit;		
						$electronic_data['ymd']=date("Ymd");	
						$electronic_data['y']=date("Y");		
						$electronic_data['m']=date("m");		
						$electronic_data['d']=date("d");	
						$electronic_data['transfer']=0;			
						$this->electronic_model->add($electronic_data);
						$this->session->set_flashdata('success_show', '激活成功');
						redirect("activation_account");
			}else{
				$this->session->set_flashdata('error_show', '激活失败');
				redirect("activation_account");
			}
		}else{
			$this->session->set_flashdata('error_show', '激活失败');
			redirect("activation_account");
		}
	}
}
/* End of file activation_account.php */
/* Location: ./application/controllers/admin/activation_account.php */