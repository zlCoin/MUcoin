<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Help extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
    }
    
	public function index($page=1,$parameter="")
	{
		$html=$this->init("帮助中心","jquery,login");
		$this->load->model('help_model');
		$search['keyword']=$this->input->post('keyword');
		$html['keyword']=$search['keyword'];
		$total_rows = $this->help_model->query_data_count($search);
		$html['pagination'] =html_pagination($page,$total_rows,$parameter);		
		$limit =html_limit($page);
		$html['maxnum']=html_num($total_rows);
		$html['list']=$this->help_model->query_data($search,$limit);
		$this->load->view('/help_list',$html);
	}	

	public function show($id=null) {
		$html=$this->init("帮助中心","jquery,login,validate");			
		$this->load->model('help_model');
		$html['row']=$this->help_model->get_row_byid($id);
		$this->load->view('/help_show',$html);
	}
}

/* End of file help.php */
/* Location: ./application/controllers/help.php */