<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Password2 extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
    }
	public function login($page) {
		$html=$this->init("二级密码","jquery,login,validate");
		$id=$this->login_lib->member_id();
		$this->load->model('member_model');
		$html['row']=$this->member_model->get_row_byid($id);
		$html['page']=$page;
		$this->load->view('/password2',$html);
	}
	public function password2_submit()
	{
		$id=$this->login_lib->member_id();
		$this->load->model('member_model');
		$member=$this->member_model->get_row_byid($id);
		$password2=$this->input->post('password2');
		$page=$this->input->post('page');
		if($member->password1!=MD5($password2)){
			$this->session->set_flashdata('error_show', '二级密码错误！');
			redirect("/password2/login/".$page);
		}else{
			$this->login_lib->set_member_password2($page);
			redirect("/".$page);
		}
	}
}

/* End of file password2.php */
/* Location: ./application/controllers/password2.php */