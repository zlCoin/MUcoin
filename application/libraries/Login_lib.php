<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Login_lib {

    function __construct() {
		$this->CI = & get_instance();
        log_message('debug', "Login Class Initialized");
    }

	function login($data) {
		$this->CI->load->model('admin_model');
		$obj = (object)null;
		$obj->user = $data['user'];
		$obj->password = $data['password'];
		$info = $this->CI->admin_model->check_login_user($obj);
		if(!empty($info)){
			$this->write_login_log($obj);
			$i->admin_id = $info->admin_id;
			$i->name = $info->name;
			$i->role_id = $info->role_id;
			$this->set_session($i);
			return true;
		}
		return false;
	}

	function login_member($data) {
		$this->CI->load->model('member_model');
		$obj = (object)null;
		$obj->user = $data['user'];
		$obj->password = $data['password'];
		$info = $this->CI->member_model->check_login_user($obj);
		if(!empty($info)){
			if($info->lock == 1){
				return "LOCK";
			}
			if(!$this->set_member_grade($info)){
				return "GRADEERROR";
			}
			$i = (object)null;
			$i->member_id = $info->member_id;
			$i->user = $info->user;
			$i->name = $info->name;
			$i->expiration_date = $info->expiration_date;
			$i->electronic_currency = $info->electronic_currency;
			$i->cash_currency = $info->cash_currency;
			$i->free_currency = $info->free_currency;
			$i->state = $info->state;
			$this->set_member_session($i);
			$this->write_login_log($obj);
			return "OK";
		}
		return "ERROR";
	}

	function set_member_grade($info) {
		$this->CI->load->model('member_model');
		$this->CI->load->model('cash_model');
		$this->CI->load->model('free_currency_model');
		$this->CI->load->model('recharge_model');
		// 个人业绩总和
		// 获取所有新会员
		$newMember = $this->CI->member_model->get_next_key_all($info->member_id, 1);
		if ($newMember) {
			// 获取所有新会员套餐;
			$priceAll = $this->CI->member_model->get_all_tc_price(implode(',', $newMember)); 
		}else{
			$priceAll = 0;
		}
		// 获取所有老会员
		$oldMember = $this->CI->member_model->get_next_key_all($info->member_id, 2);
		if ($oldMember) {
			// 获取所有老会员释放业绩
			$freeAll = $this->CI->free_currency_model->get_all_free_currency(implode(',', $oldMember)); 
		}else{
			$freeAll = 0;
		}
		$achievementAll = $priceAll + $freeAll;
		// 获取等级配置
		$gradeInfo = fun_member_level();
		// 判断等级条件
		if($achievementAll >= $gradeInfo[4]['performance'] && $this->CI->member_model->get_next_member_grade($gradeInfo[4],$info)){
			$data['grade'] = 5;
		}elseif($achievementAll >= $gradeInfo[3]['performance'] && $this->CI->member_model->get_next_member_grade($gradeInfo[3],$info)){
			$data['grade'] = 4;
		}elseif($achievementAll >= $gradeInfo[2]['performance'] && $this->CI->member_model->get_next_member_grade($gradeInfo[2],$info)){
			$data['grade'] = 3;
		}elseif($achievementAll >= $gradeInfo[1]['performance'] && $this->CI->member_model->get_next_member_grade($gradeInfo[1],$info)){
			$data['grade'] = 2;
		}elseif ($achievementAll >= $gradeInfo[0]['performance'] && $this->CI->member_model->get_next_member_grade($gradeInfo[0],$info)) {
			$data['grade'] = 1;
		}else{
			$data['grade'] = 0;
		}
		if ($info->grade < $data['grade']) {
			$update = $this->CI->member_model->update_grade($data,$info->member_id);
			return !$update ? false : true;
		}else{
			return true;
		}
	}

	function set_member_session($obj) {
		$this->CI->load->library('session');
		$this->CI->session->set_userdata('state', $obj->state); // 激活状态
		$this->CI->session->set_userdata('member_id', $obj->member_id);
		$this->CI->session->set_userdata('member_user', $obj->user);	
		$this->CI->session->set_userdata('member_name', $obj->name);
		$this->CI->session->set_userdata('expiration_date', $obj->expiration_date);
		$this->CI->session->set_userdata('member_password2', "");
	}

	function set_session($obj) {
		$this->CI->load->library('session');
		$this->CI->session->set_userdata('admin_id', $obj->admin_id);
		$this->CI->session->set_userdata('admin_name', $obj->name);	
		$this->CI->session->set_userdata('role',$obj->role_id);
		$this->CI->load->model('role_model');
		$role=$this->CI->role_model->get_role_byid($obj->role_id);	
		$this->CI->session->set_userdata('purview',"#all");
	}

	public function get_member_password2()
    {
        return$this->CI->session->userdata('member_password2');
    }

	public function set_member_password2($value)
    {
        $this->CI->session->set_userdata('member_password2',$value);
    }
    
	function is_login() {
		$admin_id = $this->CI->session->userdata('admin_id');
		if($admin_id>0)
			return true;
		else
			return false;
	}

	function is_member_login() {
		$member_id=$this->CI->session->userdata('member_id');
		if($member_id>0)
			return true;
		else
			return false;
	}
	public function purview()
    {
		return $this->CI->session->userdata('purview');
    }

    public function role()
    {
        return $this->CI->session->userdata('role');
    }
	public function set_login_member_type()
    {
        $this->CI->session->set_userdata('login_member_type', 'admin');
    }
    public function login_member_type()
    {		
        return $this->CI->session->userdata('login_member_type');
    }
	public function admin_id()
    {
        return $this->CI->session->userdata('admin_id');
    }
    public function admin_name()
    {
        return $this->CI->session->userdata('admin_name');
    }
	public function member_id()
    {
        return $this->CI->session->userdata('member_id');
    } 
	public function member_tc_price() {
		$this->CI->load->model('member_model');
		$info = $this->CI->member_model->get_row_byid($this->member_id());
		foreach (fun_switch_package() as $key => $value) {
			if ($info->tc_price == $value['numbs']) {
				return $value['version'];
			}
		}
		return false;
    } 
	public function member_grade() {
				$this->CI->load->model('member_model');
				$info = $this->CI->member_model->get_row_byid($this->member_id());
				foreach (fun_switch_level_gl() as $key => $value) {
					if ($info->grade == $value['grade']) {
						return $value['version'];
					}else{
						 return "基础会员";
					}
				}
				return false;
		} 
	public function member_expiration_date()
    {
        return $this->CI->session->userdata('expiration_date');
    }
	public function member_user()
    {
        return $this->CI->session->userdata('member_user');
    }
    public function member_name()
    {
        return $this->CI->session->userdata('member_name');
    }
	public function member_state()
	{
		return $this->CI->session->userdata('state');
	}
	public function member_electronic_currency()
    {
        return $this->CI->session->userdata('member_electronic_currency');
    }
	public function member_cash_currency()
    {
        return $this->CI->session->userdata('member_cash_currency');
    }
	public function member_free_currency()
    {
        return $this->CI->session->userdata('member_free_currency');
    }
	public function member_free_gold()
    {
        return $this->CI->session->userdata('member_free_gold');
    }
	public function member_shopping_currency()
    {
        return $this->CI->session->userdata('member_shopping_currency');
    }
	public function logout()
    {
        $this->CI->session->sess_destroy();
		redirect("/");
    }	
	public function admin_logout()
	{
		$this->CI->session->sess_destroy();
		redirect("/admin");
	}

	function write_login_log($obj) {
		$this->CI->load->model('login_log_model', 'login_log');
		$data['name'] = $obj->user;
		$this->CI->login_log->login_insert($data);
	}
}
// END Login class
/* End of file Login.php */