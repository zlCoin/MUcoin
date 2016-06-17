<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pay extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
    }
	public function index($page=1,$parameter="")
	{
		$html=$this->admin_init("网银帐单","jquery,login");
		$this->load->model('pay_model');
		$search['keyword']=$this->input->post('keyword');
		$html['keyword']=$search['keyword'];
		$total_rows = $this->pay_model->query_data_count($search);
		$html['pagination'] =html_pagination($page,$total_rows,$parameter);		
		$limit =html_limit($page);
		$html['maxnum']=html_num($total_rows);
		$html['list']=$this->pay_model->query_data($search,$limit);
		$this->load->view('/admin/pay_list',$html);
	}

	
}

/* End of file pay_list.php */
/* Location: ./application/controllers/admin/pay_list.php */