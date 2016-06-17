<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Registration extends CI_Controller {
	

	function __construct() {
		parent::__construct();
		if (!$this->login_lib->member_state()) {
			$this->session->set_flashdata('error_show', '账号未激活！');
			redirect("/account");
		}
		$this->load->model('member_model');
		$this->MemberId = $this->login_lib->member_id();
		$this->parentCount = $this->member_model->check_user_byparent_id_count($this->MemberId);
		if($this->parentCount >= 3){
			$this->session->set_flashdata('error_show', '最多注册3个账号！');
			redirect("/My_team/index");
		}
	}

	/*public function index() {
		$html=$this->init("会员注册","jquery,login,validate");
		$this->load->view('/registration',$html);
	}*/

	public function verify_user($operation=""){
		$user = $this->input->post('user_name');
		if($operation == "modify"){
			$value = $this->input->post('value');
			if($value==$user){
				echo "true";
			    die();
			}
		}
		$verify = $this->member_model->check_user_count($user);
		if($verify > 0)
			echo "false";
		else
			echo "true";
	}

	/*public function registration_submit(){
		$id = $this->MemberId;
		$member = $this->member_model->get_row_byid($id);
		$username = trim($this->input->post('user_name'));
		if (!$username || !preg_match('/^1(\d{10})$/', $username)) {
			$this->session->set_flashdata('error_show', '账号为空或者手机号填写错误！');
			redirect("/registration");
		}
		if ($this->member_model->check_user_count($username) > 0) {
			$this->session->set_flashdata('error_show', '账号已存在！');
			redirect("/registration");
		}
		if (!trim($this->input->post('name'))) {
			$this->session->set_flashdata('error_show', '真实姓名不能为空！');
			redirect("/registration");
		}
		if (!trim($this->input->post('password'))) {
			$this->session->set_flashdata('error_show', '登录密码不能为空！');
			redirect("/registration");
		}
		if (!trim($this->input->post('password1'))) {
			$this->session->set_flashdata('error_show', '二级密码不能为空！');
			redirect("/registration");
		}
		$data['user'] = $username;
		$data['parent_id'] = $id;
		$data['parent_user'] = $member->user;
		$data['password'] = md5($this->input->post('password'));
		$data['password1'] = md5($this->input->post('password1'));
		$data['name'] = $this->input->post('name');
		$data['id'] = $this->input->post('id');
		if(!empty($id)){
			// 选择套餐
			$package = fun_switch_package();
			if (!$package[$this->input->post('tc_price')]) {
				$this->session->set_flashdata('error_show', '不存在套餐');
				redirect("/registration");
			}
			$data['tc_price'] = $package[$this->input->post('tc_price')]['numbs'];
			$data['dj_price'] = $package[$this->input->post('tc_price')]['numbs'];
			$return_result = $this->member_model->add($data);
            $new_member = $this->member_model->get_row_byid($return_result);
			if($return_result > 0){
				$keyandlevel = my_get_member_keyandlevel($return_result);
				$update_member_data['key'] = $keyandlevel['key'];
				$update_member_data['key_comma'] = $keyandlevel['key_comma'];
				$update_member_data['level'] = $keyandlevel['level'];
				$this->member_model->update_data($update_member_data,$return_result);

                $this->load->model('ecs_users_model');
				$email="";
				$is_fenxiao=0;
				//$data['password'] =$data['password'];
				$this->ecs_users_model->add($data['user'],$data['password'],$data['mobile'],$email,$is_fenxiao);
 
				$this->session->set_flashdata('success_show', '会员注册成功');
				redirect("/My_team/index");
			}else{
				$this->session->set_flashdata('error_show', '会员注册失败');
				redirect("/registration");
			}
		}else{
			$this->session->set_flashdata('error_show', '会员注册失败');
			redirect("/registration");
		}
	}*/
}
/* End of file registration.php */
/* Location: ./application/controllers/registration.php */