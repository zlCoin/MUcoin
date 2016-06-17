<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class supplier extends CI_Controller {

	function __construct()
    {
        parent::__construct();
    }

	public function index()
	{
		$html = array();
		$html['error'] = $this->session->flashdata('login_error_show');
		$this->load->view('login',$html);
	}

	public function lo_gina_submit() {
		$info['user'] = $this->input->post('Username');
		$info['password'] = $this->input->post('Password');
		if(empty($info['user'])){
			$this->session->set_flashdata('login_error_show', '用户名不能为空');
			redirect('/supplier');
		}
		if(empty($info['password'])) {
			$this->session->set_flashdata('login_error_show', '密码不能为空');
			redirect('/supplier');
		}
		if($this->login_lib->login($info)){
			redirect('/admin/index');
		}else{
			$this->session->set_flashdata('login_error_show', '用户名或者密码不正确');
			redirect('/supplier');
		}
	}


	public function logout() {
		$this->login_lib->admin_logout();
	}

	function yzm()
	{
	  $conf['name']='yzm'; //作为配置参数
	  $this->load->library('captcha_code',$conf);
	  $this->captcha_code->show();
	}
}

/* End of file index.php */
/* Location: ./application/controllers/index.php */