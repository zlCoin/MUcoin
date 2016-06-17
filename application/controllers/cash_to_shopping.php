<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cash_to_shopping extends CI_Controller {


	function __construct()
    {
        parent::__construct();
        
        fun_check_member_state();	// 限制激活操作
		fun_check_password2();
    }
	public function index() {
		$html=$this->init("现金积分转购物积分","jquery,login,validate");
		$id=$this->login_lib->member_id();
		$this->load->model('member_model');
		$html['row']=$this->member_model->get_row_byid($id);
		$this->load->view('/cash_to_shopping',$html);
	}
	public function to_submit()
	{
		$this->load->model('member_model');
		$id=$this->login_lib->member_id();
		$shopping_currency=$this->input->post('shopping_currency');
		if($id!="" && $shopping_currency>=100){
			$member=$this->member_model->get_row_byid($id);
			if($member->cash_currency>=$shopping_currency){
				$return_result=$this->member_model->cash_to_shopping($shopping_currency,$id);
				//echo $this->db->last_query(); die();
				//调试
					if($return_result>0){
						// 重新读取现金积分
						$member=$this->member_model->get_row_byid($id);
						$this->load->model('cash_model');
						$data = ARRAY();
						$data['member_id']=$member->member_id;
						$data['user']=$member->user;
						$data['type']="cash_to_shopping";
						$data['cash_currency']="-".$shopping_currency;
						$data['shopping_currency']=$shopping_currency;
						$data['remark'] = "{$shopping_currency}现金积分 兑换 {$shopping_currency}购物积分 余额 {$member->cash_currency}";
						$data['ymd']=date("Ymd");
						$data['y']=date("Y");
						$data['m']=date("m");
						$data['d']=date("d");
						$return_result=$this->cash_model->add($data);
						$this->load->model('ecs_users_model');
						$num=$this->ecs_users_model->get_user_count($data['user']) ;
						if($num>0){
							    $this->load->model('ecs_users_model');
								$this->ecs_users_model->user_money($data['shopping_currency'],$data['user']) ;
								$this->session->set_flashdata('success_show', '现金积分转购物积分成功');
								redirect("cash_to_shopping");
						}else{
							    $this->member_model->cash_to_shopping_huigui($shopping_currency,$id);
								$member=$this->member_model->get_row_byid($id);
								$data = ARRAY();
								$data['member_id']=$member->member_id;
								$data['user']=$member->user;
								$data['type']="cash_to_shopping_back";
								$data['cash_currency']=$shopping_currency;
								$data['shopping_currency']=0;
								$data['remark'] = "{$shopping_currency} 现金积分 兑换 {$shopping_currency} 购物积分 失败 返还积分 余额 {$member->cash_currency}";
								$data['ymd']=date("Ymd");
								$data['y']=date("Y");
								$data['m']=date("m");
								$data['d']=date("d");
								$return_result=$this->cash_model->add($data);
								$this->session->set_flashdata('error_show', '现金积分转购物积分失败');
								redirect("cash_to_shopping");
						}
					}else{
							$this->session->set_flashdata('error_show', '现金积分转购物积分失败');
							redirect("cash_to_shopping");
					}
			}else{
							$this->session->set_flashdata('error_show', '现金积分不足转购物积分失败');
							redirect("cash_to_shopping");
				}
		}else{
			$this->session->set_flashdata('error_show', '现金积分转购物积分失败');
							redirect("cash_to_shopping");
		}
	}
}

/* End of file cash_to_electronic.php */
/* Location: ./application/controllers/cash_to_electronic.php */