<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Help extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
    }
	public function index($page=1,$parameter="")
	{
		$html=$this->admin_init("帮助管理","jquery,login");
		$this->load->model('help_model');
		$search['keyword']=$this->input->post('keyword');
		$html['keyword']=$search['keyword'];
		$total_rows = $this->help_model->query_data_count($search);
		$html['pagination'] =html_pagination($page,$total_rows,$parameter);		
		$limit =html_limit($page);
		$html['maxnum']=html_num($total_rows);
		$html['list']=$this->help_model->query_data($search,$limit);
		$this->load->view('/admin/help_list',$html);
	}

	public function add() {
		$html=$this->admin_init("帮助新增","jquery,login,validate");		
		$this->load->view('/admin/help_add',$html);
	}
	public function add_submit(){
		$this->load->model('help_model');
		$data['title']=$this->input->post('title');
		$data['content']=$this->input->post('content');
		if($data['title']!=""){
			$return_result=$this->help_model->add($data);
			if($return_result>0){
				redirect("admin/help");
			}else{
				redirect_error("帮助新增失败!","/admin/help");
			}
		}else{
			redirect_error("帮助新增失败!","/admin/help");
		}	
	}
	public function modify($id=null) {
		$html=$this->admin_init("帮助修改","jquery,login,validate");			
		$this->load->model('help_model');
		$html['row']=$this->help_model->get_row_byid($id);
		$this->load->view('/admin/help_modify',$html);
	}
	public function modify_submit()
	{
		$this->load->model('help_model');
		$id=$this->input->post('id');
		$data['title']=$this->input->post('title');
		$data['content']=$this->input->post('content');
		if($id!=""){
			$return_result=$this->help_model->update_data($data,$id);
			if($return_result>0){
				redirect("admin/help");
			}else{
				redirect_error("帮助修改失败!","/admin/help/modify/".$id);
			}
		}else{
			redirect_error("帮助修改失败!","/admin/notice/modify/".$id);
		}

	}
	public function delete($id=null)
	{
		$this->load->model('help_model');
		if($id!=null)
		{
			$return_result=$this->help_model->delete_byid($id);
			if($return_result){
				redirect("/admin/help");
			}else{
				redirect_error("帮助删除失败!","/admin/help");
			}
		}else{
			redirect_error("帮助删除没有指定ID!","/admin/help");
		}	
	}
}

/* End of file help.php */
/* Location: ./application/controllers/admin/help.php */