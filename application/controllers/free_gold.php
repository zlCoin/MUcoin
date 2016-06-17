<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Free_gold extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
		fun_check_expiration_date2();
    }
	public function index($page=1,$parameter="")
	{
		$html=$this->init("自由金明细","jquery,login");
		$this->load->model('free_gold_model');
		$search['keyword']=$this->input->post('keyword');
		$search['member_id']=$this->login_lib->member_id();
		$html['keyword']=$search['keyword'];
		$total_rows = $this->free_gold_model->query_data_count($search);
		$html['pagination'] =html_pagination($page,$total_rows,$parameter);		
		$limit =html_limit($page);
		$html['maxnum']=html_num($total_rows);
		$html['list']=$this->free_gold_model->query_data($search,$limit);
		$html['free_gold_type']=fun_free_gold_type();
		$this->load->view('/free_gold',$html);
	}
	
}

/* End of file free_gold.php */
/* Location: ./application/controllers/admin/free_gold.php */