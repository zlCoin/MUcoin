<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member_recharge extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
    }

	public function index() {
		$html=$this->admin_init("会员充值","jquery,login,validate");		
		$this->load->view('/admin/member_recharge_add',$html);
	}

	public function recharge_submit(){
		$this->load->model('member_model');
		$data['user'] = trim($this->input->post('user'));
		$data['type'] = $this->input->post('type');
		$data_kc['cz_type'] = $this->input->post('cz_type');
		$data['number']=$this->input->post('number');
		$data['remark']=$this->input->post('remark');
		if($data['user'] != ""){
			$count = $this->member_model->check_user_count($data['user']);
			if ($count) {
				$return_result = $this->member_model->recharge($data['type'],$data_kc['cz_type'],$data['number'],$data['user']);
				if($return_result > 0){
					
					$this->load->model('recharge_model');
					$memberRow = $this->member_model->get_row_byuser($data['user']);
					$data['member_id'] = $memberRow->member_id;
					$this->recharge_model->add($data);
					redirect("admin/recharge_record");
				}
			}
		}
		redirect("admin/recharge_record");
	}

	// To judge whether member exists
	public function check_member(){
		$this->load->model('member_model');
		if (isset($_POST['user'])) {
			$user = trim($this->input->post('user'));
			$count = $this->member_model->check_user_count($user);
			echo !$count ? 'false' : 'true';die;
		}else{
			echo 'false';
		}
	}
}

/* End of file member_recharge.php */
/* Location: ./application/controllers/admin/member_recharge.php */