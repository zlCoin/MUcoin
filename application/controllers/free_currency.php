<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Free_currency extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
        fun_check_member_state();	// 限制激活操作
    }
	public function index($page=1,$parameter="")
	{
		$html=$this->init("资产包明细","jquery,login");
		$this->load->model('free_currency_model');
		$search['keyword'] = $this->input->post('keyword');
		$search['member_id'] = $this->login_lib->member_id();
		$html['keyword'] = $search['keyword'];
		$total_rows = $this->free_currency_model->query_data_count($search);
		$html['pagination'] = html_pagination($page,$total_rows,$parameter);		
		$limit = html_limit($page);
		$html['maxnum'] = html_num($total_rows);
		$html['list'] = $this->free_currency_model->query_data($search,$limit);
		$html['cash_type'] = fun_cash_type();
		$this->load->view('/free_currency',$html);
	}
	
}

/* End of file free_currency.php */
/* Location: ./application/controllers/admin/free_currency.php */