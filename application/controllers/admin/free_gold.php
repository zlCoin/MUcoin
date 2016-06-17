<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Free_gold extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
    }
	public function index($page=1,$parameter="")
	{
		$html=$this->admin_init("自由金明细","jquery,login");
		$this->load->model('free_gold_model');
		$search['keyword']=$this->input->post('keyword');
		$html['keyword']=$search['keyword'];
		$total_rows = $this->free_gold_model->query_data_count($search);
		$html['pagination'] =html_pagination($page,$total_rows,$parameter);		
		$limit =html_limit($page);
		$html['maxnum']=html_num($total_rows);
		$html['list']=$this->free_gold_model->query_data($search,$limit);
		$this->load->view('/admin/free_gold',$html);
	}

	
}

/* End of file free_gold.php */
/* Location: ./application/controllers/admin/free_gold.php */