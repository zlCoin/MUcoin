<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Password_protection extends CI_Controller {
	
	
	function __construct(){
        parent::__construct();
        $this->load->model('member_model');
        $this->MemberId = $this->login_lib->member_id();
        $this->MemberInfo = $this->member_model->get_row_byid($this->MemberId);
    }

	public function index() {
		$html = $this->init("密码保护","jquery,login,validate");
		$html['row'] = $this->MemberInfo;
		$this->load->view('/password_protection',$html);
	}

	public function password_submit(){
		header('Content-type: application/json');
		$password = trim($this->input->post('password'));
		$new_password = trim($this->input->post('new_password'));
		$new_password1 = trim($this->input->post('new_password1'));
		if ($this->MemberInfo->password1 != md5($password)) {
			exit(json_encode(array('status'=>0,'info'=>'原二级密码不正确')));
		}
		if (empty($new_password) || mb_strlen($new_password,'utf-8') < 6) {
			exit(json_encode(array('status'=>0,'info'=>'新二级密码不能为空，且长度不小于六位！')));
		}
		if ($new_password != $new_password1) {
			exit(json_encode(array('status'=>0,'info'=>'新密码和确认密码不一致！')));
		}
		$data["password1"] = md5($new_password);
		$return_result = $this->member_model->update_data($data,$this->MemberId);
		if($return_result>0){
			exit(json_encode(array('status'=>1,'info'=>'更新成功！')));
		}else{
			exit(json_encode(array('status'=>0,'info'=>'更新失败！')));
		}
	}
}

/* End of file password_protection.php */
/* Location: ./application/controllers/password_protection.php */