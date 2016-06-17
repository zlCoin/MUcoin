<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}

	public function index(){
		if ($this->session->userdata('member_id')) {
			redirect('/main');
		}
		$this->load->view('index');
	}

	public function login_submit(){
		$info = array();
		$info['user'] = $this->input->post('username');
		$info['password'] = MD5($this->input->post('password'));
		$info['yzm'] = $this->input->post('verifi');
		if($info['yzm'] != $this->session->userdata("yzm"))
		{
			$data['login_error_msg'] = '验证码错误！';
			$data['login_status'] = 'invalid';
			echo json_encode($data);die;
		}
		$code = $this->login_lib->login_member($info);
		$data = array();
		if($code=="OK"){
			$data['login_status'] = 'success';
		}else if($code == "LOCK"){
			$data['login_error_msg'] = '此账户已冻结，并且没有积分赠送和领导奖';
			$data['login_status'] = 'invalid';
		}else if($code == "GRADEERROR"){
			$data['login_error_msg'] = 'Error 10001: 请联系管理员';
			$data['login_status'] = 'invalid';
		}else{
			$data['login_error_msg'] = '账号密码错误！';
			$data['login_status'] = 'invalid';
		}
		exit(json_encode($data));
	}

	public function logout(){
		$this->login_lib->logout();
	}
	
	function verifi(){
		$conf['name'] = 'yzm'; //作为配置参数
		$this->load->library('captcha_code',$conf);
		$this->captcha_code->show();
	}
}

/* End of file index.php */
/* Location: ./application/controllers/index.php */