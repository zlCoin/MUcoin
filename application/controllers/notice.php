<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notice extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
    }

	public function index($page=1,$parameter="")
	{
		$html = $this->init("公告","jquery,login");
		$this->load->model('notice_model');
		$search['keyword']=$this->input->post('keyword');
		$html['keyword']=$search['keyword'];
		$total_rows = $this->notice_model->query_data_count($search);
		$html['pagination'] =html_pagination($page,$total_rows,$parameter);		
		$limit =html_limit($page);
		$html['maxnum']=html_num($total_rows);
		$html['list']=$this->notice_model->query_data($search,$limit);
		$this->load->view('/notice_list',$html);
	}	

	public function show($id=null) {
		$html=$this->init("公告","jquery,login,validate");			
		$this->load->model('notice_model');
		$html['row']=$this->notice_model->get_row_byid($id);
		$this->load->view('/notice_show',$html);
	}
}

/* End of file notice.php */
/* Location: ./application/controllers/notice.php */