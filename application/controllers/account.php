<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
    }

	public function index() {
		$html=$this->init("账户信息","jquery,login,validate");
		$id = $this->login_lib->member_id();
		$this->load->model('member_model');
		$html['row'] = $this->member_model->get_row_byid($id);
		$this->load->model('system_set_model');
		$system_set=$this->system_set_model->get_row_byid(1);
		$this->load->view('/account',$html);
	}

	public function modify_submit(){
		$this->load->model('member_model');
		$id = $this->login_lib->member_id();
		$data['email'] = $this->input->post('email');
		$data['qq'] = $this->input->post('qq');
		if($id){
			$return_result = $this->member_model->update_data($data,$id);
			if($return_result>0){
				$this->session->set_flashdata('success_show', '修改成功');
			}else{				
				$this->session->set_flashdata('error_show', '修改失败');
			}
		}else{
			$this->session->set_flashdata('error_show', '修改失败');
		}
		redirect("account");
	}
}

/* End of file account.php */
/* Location: ./application/controllers/account.php */