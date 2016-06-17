<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Buy_free_stock extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
		fun_check_password2();
    }

	public function index()
	{
		$this->load->model('member_model');
		$this->load->model('system_set_model');
		$this->load->model('free_stock_model');
		$html=$this->init("追加自由股","jquery,login");
		$system_set = $this->system_set_model->get_row_byid(1);
		$id = $this->login_lib->member_id();
		$html['row'] = $this->member_model->get_row_byid($id);
		$html['system_set'] = $system_set;
		$html['stock_max']=$this->free_stock_model->get_allow_buy_stock_count($this->login_lib->member_id());
		$html['free_stock_count'] = $this->free_stock_model->get_member_count($id,$system_set->dividend_time);
		$this->load->view('/buy_free_stock',$html);
	}

 public function buy_submit(){
		$this->load->model('member_model');
		$this->load->model('system_set_model');
		$this->load->model('free_stock_model');

		$id = $this->login_lib->member_id();
		$member = $this->member_model->get_row_byid($id);

		$number = 1;//$this->input->post('number');
		
		$system_set = $this->system_set_model->get_row_byid(1);

		// 选择套餐
		$package = fun_switch_package();
		$packageNum = $package[$this->input->post('keys')];

		if (!$packageNum) {
			$this->session->set_flashdata('error_show', '不存在套餐');
			redirect("free_stock_market");
		}

		$electronic = $number * $packageNum['numbs'];	// 购买的积分

		if($member->state == 0){
			$this->session->set_flashdata('error_show', '您还没有激活');
			redirect("free_stock_market");
		}
		
		if (!$this->free_stock_model->check_user_stock($id,$number))
		{			
			$this->session->set_flashdata("error_show", "购买失败,请先增加直推人再购买自由股!");
			redirect("free_stock_market");
		}

		// 判断积分是否不足
		if($member->electronic_currency >= $electronic){
			$return_result = $this->member_model->minus_electronic($electronic,$id,$number);
			if($return_result>0){
				$data['number'] = $number;
				$data['member_id'] = $id;
				$data['parent_id_count'] = $this->member_model->check_user_byparent_id_count($member->member_id);
				$data['user'] = $member->user;
				$data['clue'] = $member->key;
				$data['level'] = $member->level;
				$data['no'] = date('Ymdhis').rand(1000,9999);
				$data['day_dividend'] = $electronic;
				$data['expiration_date']=$member->expiration_date;
				if($data['member_id'] != ""){
					$return_result = $this->free_stock_model->add($data);
					if($return_result > 0){
						if($member->parent_id > 0 || $member->parent_user != ""){	
							$member2 = $this->member_model->get_row_byid($member->parent_id);
							$cash_currency_bonus = $system_set->bonus*$number;
							$this->member_model->add_cash($cash_currency_bonus,$member2->member_id);
							$this->load->model('cash_model');
							$cash_data['member_id']=$member2->member_id;					
							$cash_data['user']=$member2->user;
							$cash_data['from_member_id']=$member->member_id;		
							$cash_data['from_user']=$member->user;			
							$cash_data['type']="recommend";				
							$cash_data['cash_currency']=$cash_currency_bonus;
							$cash_data['ymd']=date("Ymd");	
							$cash_data['y']=date("Y");		
							$cash_data['m']=date("m");		
							$cash_data['d']=date("d");	
							$this->cash_model->add($cash_data);
							$this->load->model('recommend_model');
							$recommend_data['member_id']=$member2->member_id;		
							$recommend_data['user']=$member2->user;
							$recommend_data['from_member_id']=$member->member_id;		
							$recommend_data['from_user']=$member->user;				
							$recommend_data['money']=$cash_currency_bonus;	
							$recommend_data['atime']=time();	
							$recommend_data['ymd']=date("Ymd");	
							$recommend_data['y']=date("Y");		
							$recommend_data['m']=date("m");		
							$recommend_data['d']=date("d");						
							$this->recommend_model->add($recommend_data);
						}
						$this->load->model('electronic_model');
						$electronic_data['member_id']=$member->member_id;		
						$electronic_data['user']=$member->user;					
						$electronic_data['type']="electronic_buy_free_stock";			
						$electronic_data['electronic_currency']=$electronic;		
						$electronic_data['ymd']=date("Ymd");	
						$electronic_data['y']=date("Y");		
						$electronic_data['m']=date("m");		
						$electronic_data['d']=date("d");						
						$this->electronic_model->add($electronic_data);
						$this->session->set_flashdata('success_show', '追加自由股成功');
						redirect("free_stock_market");
					}else{
						$this->session->set_flashdata('error_show', '追加自由股失败');
						redirect("buy_free_stock");
					}
				}else{
					$this->session->set_flashdata('error_show', '追加自由股失败');
					redirect("buy_free_stock");
				}
			}
		}else{
			$this->session->set_flashdata('error_show', '追加自由股失败');
			redirect("buy_free_stock");
		}
	}
}

/* End of file buy_free_stock.php */
/* Location: ./application/controllers/admin/buy_free_stock.php */