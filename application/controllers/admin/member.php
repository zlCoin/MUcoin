<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->model('member_model');
	}

	public function index($page=1,$parameter="")
	{
		$html=$this->admin_init("会员","jquery,login,date");
		$search['keyword'] = $this->input->post('keyword');
		$search['state'] = 1;
		$html['keyword'] = $search['keyword'];
		$total_rows = $this->member_model->query_data_count($search);
		$html['pagination'] = html_pagination($page,$total_rows,$parameter);		
		$limit = html_limit($page);
		$html['maxnum'] = html_num($total_rows);
		$html['total_rows'] = $total_rows;
		$html['list'] = $this->member_model->query_data($search,$limit);
		$this->load->view('/admin/member_list',$html);
	}

	public function unlocking($id){
		$this->load->model('member_model');
		if($id != ""){
			$data['lock']=0;
			$return_result=$this->member_model->update_data($data,$id);
			if($return_result>0){
				$this->load->model('free_stock_model');
				$this->free_stock_model->update_unlocking($id);
				redirect("admin/member");
			}else{
				redirect("admin/member");
			}
		}else{
			redirect("admin/member");
		}
	}

	public function login($id) {
		$this->load->model('member_model');
		$member = $this->member_model->get_row_byid($id);
		$info['user']=$member->user;
		$info['password']=$member->password;
		if($this->login_lib->login_member($info)){
			$this->login_lib->set_login_member_type();
			redirect('/main');
			die();
		}else{

		}
	}

	public function modify($id=null) {
		$html=$this->admin_init("用户修改","jquery,validate,date");			
		$html['row'] = $this->member_model->get_row_byid($id);
		$this->load->view('/admin/member_modify',$html);
	}

	public function modify_submit(){
		$id = $this->input->post('id');
		$data['name'] = $this->input->post('name');
		$password = $this->input->post('password');
		$password_again = $this->input->post('password_again');
		if($password!="" && $password == $password_again)
			$data['password'] = MD5($this->input->post('password'));
		$password1 = $this->input->post('password1');		
		if($password1 != "")
			$data['password1'] = MD5($this->input->post('password1'));
		$package = fun_switch_package();
		$tc_price = $this->input->post('tc_price');
		if (!isset($package[$tc_price])) {
			die('请选择套餐！');
		}
		$data['tc_price'] = $package[$tc_price]['numbs'];
		$data['mobile']=$this->input->post('mobile');
		$data['email']=$this->input->post('email');
		$data['qq']=$this->input->post('qq');
		$data['lock']=$this->input->post('lock');
		$data['remark']=$this->input->post('remark');
		if($id != ""){
			$return_result = $this->member_model->update_data($data,$id);
			if($return_result > 0){
				if($data['lock']==1){					
					$this->load->model('free_stock_model');
					$this->free_stock_model->update_lock($id);
				}else{			
					$this->load->model('free_stock_model');
					$this->free_stock_model->update_unlocking($id);
				}
				redirect("admin/member");
			}
		}
		die("用户修改失败!");
	}

	public function reg_ec_usertb()
	{
		$this->load->model('member_model');
		$this->load->model('ecs_users_model');
		$id=intval($this->uri->segment(5));
        /*//根据用户名查询此人详细*/
        $data33=$this->member_model->get_row_byid($id);
        //PHP中把stdClass Object转array的方法
		$data33 =  json_decode(json_encode( $data33),true);
			if($data33){
             $data['user']=$data33['user'];
             $username_true=$this->ecs_users_model->get_user_count($data33['user']);
               if($username_true=='1'){
				   $neirong1=iconv("UTF-8", "GB2312//IGNORE", '此账户已在商城存在');
				   echo("<script language=\"javascript\">alert('".$neirong1."');window.top.location.href='/admin/member/modify/".$id."';</script>");
			   }
				$data['password']=$data33['password'];
				$data['mobile']=$data33['mobile'];
				$email='';
				$this->ecs_users_model->add($data['user'],$data['password'],$data['mobile'],$email);
				$neirong2=iconv("UTF-8", "GB2312//IGNORE", '同步成功');
				  echo "<script language=\"javascript\">alert('".$neirong2."');window.top.location.href='/admin/member/modify/".$id."';</script>";
			}else{
				$neirong3=iconv("UTF-8", "GB2312//IGNORE", '同步失败'); 
				 echo "<script language=\"javascript\">alert('".$neirong3."');window.top.location.href='/admin/member/modify/".$id."';</script>";
			}
	}
}

/* End of file member.php */
/* Location: ./application/controllers/admin/member.php */