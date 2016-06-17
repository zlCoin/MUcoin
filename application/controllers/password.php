<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Password extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
		fun_check_password2();
    }

	public function index() {
		$html=$this->init("密码变更","jquery,login,validate");
		$id=$this->login_lib->member_id();
		$this->load->model('member_model');
		$html['row'] = $this->member_model->get_row_byid($id);
		$this->load->view('/password',$html);
	}

	public function password_submit(){
		$this->load->model('member_model');
		$id = $this->login_lib->member_id();
		$member = $this->member_model->get_row_byid($id);
		$original_password = $this->input->post('original_password');
		if($member->password != MD5($original_password)){
			$this->session->set_flashdata('error_show', '修改错误，原密码不正确！');
			redirect("/password");
		}
		$password = $this->input->post('password');
		$password_again = $this->input->post('password_again');
		if(!empty($password)){
			if($password == $password_again){
				$data['password'] = MD5($this->input->post('password'));
			}else{
				$this->session->set_flashdata('error_show', '两次输入密码不一致！');
				redirect("/password");
			}
		}else{
			$this->session->set_flashdata('error_show', '新密码不能为空！');
			redirect("/password");
		}
		$return_result = $this->member_model->update_data($data,$id);
		if($return_result > 0){
			$this->session->set_flashdata('success_show', '密码修改成功！');
			redirect("/password");
		}else{
			$this->session->set_flashdata('error_show', '密码修改失败！');
			redirect("/password");
		}
	}
}

/* End of file password.php */
/* Location: ./application/controllers/password.php */