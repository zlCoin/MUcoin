<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class team_password_controller extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
		fun_check_password2();
    }
	public function index() {
		$html=$this->init("直属团队密码变更","jquery,login,validate");
		$id=$this->login_lib->member_id();
		//$this->load->model('member_model');
		//$html['row']=$this->member_model->get_row_byid($id);
		
		$this->load->model('team_password_model');
		$html['TeamMember']=$this->team_password_model->get_TeamMember_byparentid($id);
		
		$this->load->view('/team_password_view',$html);
	}
	
	public function JumpToTeamPassword($member_id) {
		$html=$this->init("直属团队密码变更","jquery,login,validate");
		$id=$this->login_lib->member_id();		
		$this->load->model('team_password_model');
		$html['TeamMember']=$this->team_password_model->get_TeamMember_byparentid($id);
		$html['TeamMemberSelected']="";
		
		//set dropdownlist
		$result = $this->team_password_model->get_user_bymember_id($member_id);
		if (empty($result))
		{
			redirect("/team_password_controller");
		}
		else
		{
			foreach($result as $keyname =>$value){
				if($keyname == "user"){
					$user = $value->user;					
				}
			}
		}
		
		if (strlen($user) > 0)
		{
			$html['TeamMemberSelected']=$user;
		}
		else
		{
			$html['TeamMemberSelected']="";
		}
		
		$this->load->view('/team_password_view',$html);
	}
	
	public function StrFormat() {   
  
		$args = func_get_args();  

		if (count($args) == 0) { return;}  

		if (count($args) == 1) { return $args[0]; }
		 
		$str = array_shift($args);    
		 
		$str = preg_replace_callback('/\\{(0|[1-9]\\d*)\\}/', create_function('$match', '$args = '.var_export($args, true).'; return isset($args[$match[1]]) ? $args[$match[1]] : $match[0];'), $str);
		 
		return $str;
 
	} 
	
	public function TeamPassword_Submit()
	{
		//get parent id
		$parent_id=$this->login_lib->member_id();
		
		//get user
		$user=$this->input->post('TeamMember');	
		
		//password
		$password=$this->input->post('password');
		$password_again=$this->input->post('password_again');
		
		//password1
		$password_second=$this->input->post('password1');
		$password_second_again=$this->input->post('password1_again');
		
		//validate empty
		if (strlen($password) < 8 )
		{
			$this->session->set_flashdata('error_show', '新登录密码必须大于8个字符!');
			redirect("/team_password_controller");
			return;
		}else if (strlen($password_again) < 8 )
		{
			$this->session->set_flashdata('error_show', '确认登录密码必须大于8个字符!');
			redirect("/team_password_controller");	
			return;		
		}else if (strlen($password_second) < 8 )
		{
			$this->session->set_flashdata('error_show', '二级密码必须大于8个字符!');
			redirect("/team_password_controller");	
			return;		
		}else if (strlen($password_second_again) < 8 )
		{
			$this->session->set_flashdata('error_show', '确认二级密码必须大于8个字符!');
			redirect("/team_password_controller");
			return;
		}else if (strlen($user) == 0 || strlen($user) == "请选择")
		{
			$this->session->set_flashdata('error_show', '请先选择一个用户!');
			redirect("/team_password_controller");
			return;
		}
		
		
		//validate password same as confirm password
		if($password <> $password_again)
		{
			$this->session->set_flashdata('error_show', '两次登录密码不一致!');
			redirect("/team_password_controller");
			return;	
		}else if ($password_second <> $password_second_again)
		{
			$this->session->set_flashdata('error_show', '两次二级密码不一致!');
			redirect("/team_password_controller");
			return;
		}
		
		//set data array and encrypt to md5
		$data['password']=MD5($this->input->post('password'));
		$data['password1']=MD5($this->input->post('password1'));	
		
		
		
		if($data['password']!="" && $data['password1']!=""){
			
			//load model
			$this->load->model('team_password_model');
			$return_result=$this->team_password_model->update_TeamMemberPwd($data,$parent_id,$user);
			
			
			if($return_result>0){				
				$this->session->set_flashdata('success_show', '密码修改成功');
				redirect("/team_password_controller");
			}else{
				$this->session->set_flashdata('error_show', '密码修改失败,请重试!');
				redirect("/team_password_controller");
			}
		}

	}
}

/* End of file password.php */
/* Location: ./application/controllers/password.php */