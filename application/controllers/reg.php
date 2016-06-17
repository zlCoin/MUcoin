<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reg extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('member_model');
	}

	public function member() {
		$this->load->view('reg');
	}

	public function memberAll(){
		$all = $this->member_model->test_allls();
		foreach ($all as $key => $value) {
			$parent = $this->member_model->test_member($value['parent_id']);
			if (!$parent) {
				echo $value['parent_id']."-----------".$value['parent_user']."<br />";
			}
		}
		die;
	}

	private function verifyParentUser($user){
		$count = $this->member_model->check_user_count($user);
		return !$count ? false : true;
	}

	public function verifyMobile($mobile){
		$count = $this->member_model->check_mobile_count($mobile);
		return $count ? false : true;
	}

	// 判断推荐人和节点人在不在一个队列内
	public function checkRemmonNode($recommendUser, $nodeUser){
		$Recommen = $this->member_model->get_row_byuser($recommendUser);
		$node = $this->member_model->get_row_byuser($nodeUser);
		$result =  $this->member_model->check_member_queue($Recommen->member_id, $node->member_id);
		return !$result ? false : true;
	}

	public function reg_submit(){
		header('Content-Type:application/json; charset=utf-8');
		// 检测验证码
		$verifi = $this->input->post('verifi');
		if($verifi != $this->session->userdata("yzm")) exit(json_encode(array('status'=>0,'info'=>'验证码错误')));
		// 检测推荐人
		$recommendUser = trim($this->input->post('recommend_user'));
		$recommendUserInfo = $this->member_model->get_row_byuser($recommendUser);
		if (empty($recommendUser)) exit(json_encode(array('status'=>0,'info'=>'推荐人不能为空')));
		if (!$recommendUserInfo) exit(json_encode(array('status'=>0,'info'=>'推荐人不存在')));
		if (!$recommendUserInfo->state) exit(json_encode(array('status'=>0,'info'=>'推荐人未激活')));

		// 检测节点人
		$parent = trim($this->input->post('parent_user'));
		if (empty($parent)) exit(json_encode(array('status'=>0,'info'=>'节点人不能为空')));
		$NodeUserInfo = $this->member_model->get_row_byuser($parent);
		if (!$NodeUserInfo) exit(json_encode(array('status'=>0,'info'=>'节点人不存在')));
		if (!$NodeUserInfo->state) exit(json_encode(array('status'=>0,'info'=>'节点人未激活')));
		$parentCount = $this->member_model->my_team_count(array('parent_user'=>$parent));
		if ($parentCount >= 3 && $NodeUserInfo->member_id != 3) {
			exit(json_encode(array('status'=>0,'info'=>'节点人位置已满')));
		}
		if (!$this->checkRemmonNode($recommendUser, $parent)) {
			exit(json_encode(array('status'=>0,'info'=>'推荐人和节点人不在一个队列内')));
		}
		// 检测套餐
		$package = fun_switch_package();
		$tc_price = $this->input->post('tc_price');
		if (!isset($package[$tc_price])) {
			exit(json_encode(array('status'=>0,'info'=>'请选择套餐！')));
		}
		// 检测用户名
		$username = trim($this->input->post('user'));
		if (empty($username)) exit(json_encode(array('status'=>0,'info'=>'用户名不能为空')));
		if (!preg_match("/^[A-Za-z0-9]([A-Za-z0-9]{5,16})+$/", $username)) exit(json_encode(array('status'=>0,'info'=>'用户名由字母和数字组成,6-16位')));
		if ($this->verifyParentUser($username)) exit(json_encode(array('status'=>0,'info'=>'用户名已存在！')));
		// 检测姓名
		$nickname = trim($this->input->post('name'));
		if (empty($nickname)) exit(json_encode(array('status'=>0,'info'=>'姓名不能为空')));
		if (!preg_match("/^[\x{4e00}-\x{9fa5}]+$/u",$nickname)) exit(json_encode(array('status'=>0,'info'=>'姓名必须是汉字')));
		// 检测手机号
		$mobile = trim($this->input->post('mobile'));
		if (empty($mobile)) exit(json_encode(array('status'=>0,'info'=>'手机不能为空')));
		if (!preg_match("/^1([0-9]{10})+$/", $mobile)) exit(json_encode(array('status'=>0,'info'=>'手机格式错误')));
		if (!$this->verifyMobile($mobile)) exit(json_encode(array('status'=>0,'info'=>'手机号已注册')));
		// 检测登录密码
		$password = trim($this->input->post('password'));
		$password_again = trim($this->input->post('password_again'));
		if (empty($password)) exit(json_encode(array('status'=>0,'info'=>'密码不能为空')));
		if (mb_strlen($password,'utf-8') < 6) exit(json_encode(array('status'=>0,'info'=>'登录密码最少6位')));
		if ($password != $password_again) exit(json_encode(array('status'=>0,'info'=>'两次输入的登录密码不一致！')));
		// 检测安全密码
		$password1 = trim($this->input->post('password1'));
		$password1_again = trim($this->input->post('password1_again'));
		if (empty($password1)) exit(json_encode(array('status'=>0,'info'=>'二级密码不能为空')));
		if (mb_strlen($password1,'utf-8') < 6) exit(json_encode(array('status'=>0,'info'=>'二级密码最少6位')));
		if ($password1 != $password1_again) exit(json_encode(array('status'=>0,'info'=>'两次输入的二级密码不一致！')));
		$data['recommend_id'] = my_member_id_byuser($recommendUser);
		$data['parent_id'] = my_member_id_byuser($parent);
		$data['parent_user'] = $parent;
		$data['user'] = $username;
		$data['name'] = $nickname;
		$data['mobile'] = $mobile;
		$data['password'] = MD5($password);
		$data['password1'] = MD5($password1);
		$data['tc_price'] = $package[$tc_price]['numbs'];
		$return_result = $this->member_model->add($data);
		if($return_result){
			$keyandlevel = my_get_member_keyandlevel($return_result);
			$update_member_data['key'] = $keyandlevel['key'];
			$update_member_data['key_comma'] = $keyandlevel['key_comma'];
			$update_member_data['level'] = $keyandlevel['level'];
			$this->member_model->update_data($update_member_data,$return_result);
			exit(json_encode(array('status'=>1,'info'=>'注册成功')));
		}else{
			exit(json_encode(array('status'=>0,'info'=>'注册失败')));
		}
	}
}

/* End of file reg.php */
/* Location: ./application/controllers/reg.php */