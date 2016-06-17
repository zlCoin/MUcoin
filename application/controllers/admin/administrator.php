<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Administrator extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
    }
	public function index($page=1,$parameter="")
	{
		$html=$this->admin_init("管理员","jquery,login");
		$this->load->model('admin_model');
		$search['keyword']=$this->input->post('keyword');
		$html['keyword']=$search['keyword'];
		$total_rows = $this->admin_model->query_data_count($search);
		$html['pagination'] =html_pagination($page,$total_rows,$parameter);		
		$limit =html_limit($page);
		$html['maxnum']=html_num($total_rows);
		$html['list']=$this->admin_model->query_data($search,$limit);
		//echo $this->db->last_query();
		$this->load->model('role_model');
		$html['role']=$this->role_model->get_all_toarray();
		$this->load->view('/admin/administrator_list',$html);
	}

	public function add() {
		$html=$this->admin_init("管理员新增","jquery,login,validate");		
		$this->load->model('role_model');
		$html['role']=$this->role_model->get_all_toarray();
		$this->load->view('/admin/administrator_add',$html);
	}
	public function add_submit(){
		$this->load->model('admin_model');
		$data['user']=$this->input->post('user');
		$data['password']=MD5($this->input->post('password'));
		$data['name']=$this->input->post('name');
		$data['mobile']=$this->input->post('mobile');
		$data['email']=$this->input->post('email');
		$data['role_id']=$this->input->post('role_id');
		if($data['name']!="" && $data['password']!=""){
			$return_result=$this->admin_model->add($data);
			if($return_result>0){
				redirect("admin/administrator");
			}else{
				redirect_error("管理员新增失败!","/admin/administrator");
			}
		}else{
			redirect_error("管理员新增失败!","/admin/administrator");
		}	
	}
	public function modify($id=null) {
		$html=$this->admin_init("管理员修改","jquery,login,validate");			
		$this->load->model('admin_model');
		$html['row']=$this->admin_model->get_row_byid($id);
		$this->load->model('role_model');
		$html['role']=$this->role_model->get_all_toarray();
		$this->load->view('/admin/administrator_modify',$html);
	}
	public function modify_submit()
	{
		$this->load->model('admin_model');
		$id=$this->input->post('id');
		$password=$this->input->post('password');
		$password_again=$this->input->post('password_again');
		if($password!="" && $password==$password_again)
			$data['password']=MD5($this->input->post('password'));
		$data['name']=$this->input->post('name');
		$data['mobile']=$this->input->post('mobile');
		$data['email']=$this->input->post('email');
		$data['role_id']=$this->input->post('role_id');
		if($id!=""){
			$return_result=$this->admin_model->update_data($data,$id);
		//	echo $return_result;
			//echo $this->db->last_query();die();
			if($return_result>0){
				redirect("admin/administrator");
			}else{
				redirect_error("管理员修改失败!","/admin/administrator/modify/".$id);
			}
		}else{
			redirect_error("管理员修改失败!","/admin/administrator/modify/".$id);
		}

	}
	public function delete($id=null)
	{
		$this->load->model('admin_model');
		if($id!=null)
		{
			$return_result=$this->admin_model->delete_byid($id);
			if($return_result){
				redirect("/admin/administrator");
			}else{
				redirect_error("管理员删除失败!","/admin/administrator");
			}
		}else{
			redirect_error("管理员删除没有指定ID!","/admin/administrator");
		}	
	}
}

/* End of file administrator.php */
/* Location: ./application/controllers/admin/administrator.php */