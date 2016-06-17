<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Message extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
    }
	public function index($page=1,$parameter="")
	{
		$html=$this->admin_init("留言","jquery,login");
		$this->load->model('message_model');
		$search['keyword']=$this->input->post('keyword');
		$html['keyword']=$search['keyword'];
		$total_rows = $this->message_model->query_data_count($search);
		$html['pagination'] =html_pagination($page,$total_rows,$parameter);		
		$limit =html_limit($page);
		$html['maxnum']=html_num($total_rows);
		$html['list']=$this->message_model->query_data($search,$limit);
		$this->load->view('/admin/message_list',$html);
	}
	public function reply($id=null) {
		$html=$this->admin_init("留言回复","jquery,login,validate");			
		$this->load->model('message_model');
		$html['row']=$this->message_model->get_row_byid($id);
		$this->load->view('/admin/message_modify',$html);
	}
	public function reply_submit()
	{
		$this->load->model('message_model');
		$id=$this->input->post('id');
		$data['title']=$this->input->post('title');
		$data['content']=$this->input->post('content');
		if($id!=""){
			$return_result=$this->message_model->update_data($data,$id);
			if($return_result>0){
				redirect("admin/message");
			}else{
				redirect_error("留言回复失败!","/admin/message/modify/".$id);
			}
		}else{
			redirect_error("留言回复失败!","/admin/message/modify/".$id);
		}

	}
	public function delete($id=null)
	{
		$this->load->model('message_model');
		if($id!=null)
		{
			$return_result=$this->message_model->delete_byid($id);
			if($return_result){
				redirect("/admin/message");
			}else{
				redirect_error("留言删除失败!","/admin/message");
			}
		}else{
			redirect_error("留言删除没有指定ID!","/admin/message");
		}	
	}
}

/* End of file message.php */
/* Location: ./application/controllers/admin/message.php */