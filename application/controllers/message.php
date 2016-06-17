<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Message extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
    }
	public function index($page=1,$parameter="")
	{
		$html=$this->init("留言板","jquery,login");
		$this->load->model('message_model');
		$search['keyword']=$this->input->post('keyword');
		$html['keyword']=$search['keyword'];
		$total_rows = $this->message_model->query_data_count($search);
		$html['pagination'] =html_pagination($page,$total_rows,$parameter);		
		$limit =html_limit($page);
		$html['maxnum']=html_num($total_rows);
		$html['list']=$this->message_model->query_data($search,$limit);
		$this->load->view('/message_list',$html);
	}	

	public function show($id=null) {
		$html=$this->init("留言板","jquery,login,validate");			
		$this->load->model('message_model');
		$html['row']=$this->message_model->get_row_byid($id);
		$this->load->view('/message_show',$html);
	}
}

/* End of file message.php */
/* Location: ./application/controllers/message.php */