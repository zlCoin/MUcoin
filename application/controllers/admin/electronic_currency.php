<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Electronic_currency extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
    }
	public function index($page=1,$parameter="")
	{
		$html=$this->admin_init("电子积分明细","jquery,login");
		$this->load->model('electronic_model');
		$search['keyword']=$this->input->post('keyword');
		$html['keyword']=$search['keyword'];
		$total_rows = $this->electronic_model->query_data_count($search);
		$html['pagination'] =html_pagination($page,$total_rows,$parameter);		
		$limit =html_limit($page);
		$html['maxnum']=html_num($total_rows);
		$html['list']=$this->electronic_model->query_data($search,$limit);
		$this->load->view('/admin/electronic_currency',$html);
	}

	
}

/* End of file electronic_currency.php */
/* Location: ./application/controllers/admin/electronic_currency.php */