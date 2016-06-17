<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cash_currency extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
    }
	public function index($page=1,$parameter="")
	{
		$html=$this->admin_init("现金积分明细","jquery,login");
		$this->load->model('cash_model');
		$search['keyword']=$this->input->post('keyword');
		$html['keyword']=$search['keyword'];
		$total_rows = $this->cash_model->query_data_count($search);
		$html['pagination'] =html_pagination($page,$total_rows,$parameter);		
		$limit =html_limit($page);
		$html['maxnum']=html_num($total_rows);
		$html['list']=$this->cash_model->query_data($search,$limit);
		$html['cash_type'] = fun_cash_type();
		$this->load->view('/admin/cash_currency',$html);
	}

	
}

/* End of file cash_currency.php */
/* Location: ./application/controllers/admin/cash_currency.php */