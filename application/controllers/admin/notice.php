<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notice extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
    }

	public function index($page=1,$parameter="")
	{
		$html=$this->admin_init("公告管理","jquery,login");
		$this->load->model('notice_model');
		$search['keyword'] = $this->input->post('keyword');
		$html['keyword'] = $search['keyword'];
		$total_rows = $this->notice_model->query_data_count($search);
		$html['pagination'] = html_pagination($page,$total_rows,$parameter);		
		$limit = html_limit($page);
		$html['maxnum'] = html_num($total_rows);
		$html['list'] = $this->notice_model->query_data($search,$limit);
		$this->load->view('/admin/notice_list',$html);
	}

	public function add() {
		$html=$this->admin_init("公告新增","jquery,login,validate");		
		$this->load->view('/admin/notice_add',$html);
	}

	public function add_submit(){
		$this->load->model('notice_model');
		$data['title']=$this->input->post('title');
		$data['content']=$this->input->post('content');
		if($data['title']!=""){
			$return_result=$this->notice_model->add($data);
			if($return_result>0){
				redirect("admin/notice");
			}else{
				redirect_error("公告新增失败!","/admin/notice");
			}
		}else{
			redirect_error("公告新增失败!","/admin/notice");
		}	
	}

	public function modify($id=null) {
		$html=$this->admin_init("公告修改","jquery,login,validate");			
		$this->load->model('notice_model');
		$html['row']=$this->notice_model->get_row_byid($id);
		$this->load->view('/admin/notice_modify',$html);
	}

	public function modify_submit()
	{
		$this->load->model('notice_model');
		$id=$this->input->post('id');
		$data['title']=$this->input->post('title');
		$data['content']=$this->input->post('content');
		if($id!=""){
			$return_result=$this->notice_model->update_data($data,$id);
			if($return_result>0){
				redirect("admin/notice");
			}else{
				redirect_error("公告修改失败!","/admin/notice/modify/".$id);
			}
		}else{
			redirect_error("公告修改失败!","/admin/notice/modify/".$id);
		}
	}
	
	public function delete($id=null)
	{
		$this->load->model('notice_model');
		if($id!=null)
		{
			$return_result=$this->notice_model->delete_byid($id);
			if($return_result){
				redirect("/admin/notice");
			}else{
				redirect_error("公告删除失败!","/admin/notice");
			}
		}else{
			redirect_error("公告删除没有指定ID!","/admin/notice");
		}	
	}
}

/* End of file notice.php */
/* Location: ./application/controllers/admin/notice.php */