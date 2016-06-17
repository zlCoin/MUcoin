<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Role extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
    }
	public function index($page=1,$parameter="")
	{
		$html=$this->admin_init("角色","jquery,login");
		$this->load->model('role_model');
		$search['keyword']=$this->input->post('keyword');
		$html['keyword']=$search['keyword'];
		$total_rows = $this->role_model->query_data_count($search);
		$html['pagination'] =html_pagination($page,$total_rows,$parameter);		
		$limit =html_limit($page);
		$html['maxnum']=html_num($total_rows);
		$html['list']=$this->role_model->query_data($search,$limit);
		$this->load->view('/admin/role_list',$html);
	}

	public function add() {
		$html=$this->admin_init("角色新增","jquery,login,validate");		
		$this->load->view('/admin/role_add',$html);
	}
	public function add_submit(){
		$this->load->model('role_model');
		$data['name']=$this->input->post('name');
		$data['description']=$this->input->post('description');
		$data['purview']=$this->input->post('purview');
		if($data['name']!=""){
			$return_result=$this->role_model->add($data);
			if($return_result>0){
				redirect("admin/role");
			}else{
				redirect_error("角色新增失败!","/admin/role");
			}
		}else{
			redirect_error("角色新增失败!","/admin/role");
		}	
	}
	public function modify($id=null) {
		$html=$this->admin_init("角色修改","jquery,login,validate");			
		$this->load->model('role_model');
		$html['row']=$this->role_model->get_row_byid($id);
		$this->load->view('/admin/role_modify',$html);
	}
	public function modify_submit()
	{
		$this->load->model('role_model');
		$id=$this->input->post('id');
		$data['name']=$this->input->post('name');
		$data['description']=$this->input->post('description');
		$data['purview']=$this->input->post('purview');
		if($id!=""){
			$return_result=$this->role_model->update_data($data,$id);
			if($return_result>0){
				redirect("admin/role");
			}else{
				redirect_error("角色修改失败!","/admin/role/modify/".$id);
			}
		}else{
			redirect_error("角色修改失败!","/admin/role/modify/".$id);
		}

	}
	public function delete($id=null)
	{
		$this->load->model('role_model');
		if($id!=null)
		{
			$return_result=$this->role_model->delete_byid($id);
			if($return_result){
				redirect("/admin/role");
			}else{
				redirect_error("角色删除失败!","/admin/role");
			}
		}else{
			redirect_error("角色删除没有指定ID!","/admin/role");
		}	
	}
}

/* End of file role.php */
/* Location: ./application/controllers/admin/role.php */