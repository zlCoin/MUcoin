<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Free_currency extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
    }
	public function index($page=1,$parameter="")
	{
		$html=$this->admin_init("自由积分明细","jquery,login");
		$this->load->model('free_currency_model');
		$search['keyword']=$this->input->post('keyword');
		$html['keyword']=$search['keyword'];
		$total_rows = $this->free_currency_model->query_data_count($search);
		$html['pagination'] =html_pagination($page,$total_rows,$parameter);		
		$limit =html_limit($page);
		$html['maxnum']=html_num($total_rows);
		$html['list']=$this->free_currency_model->query_data($search,$limit);
		$html['cash_type'] = fun_cash_type();
		$this->load->view('/admin/free_currency',$html);
	}

	
}

/* End of file free_currency.php */
/* Location: ./application/controllers/admin/free_currency.php */