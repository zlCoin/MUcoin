<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Baodan_log extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
	}

	public function index($page=1,$parameter=""){
		$html = $this->init("报单积分明细","jquery");
		$this->load->model('Baodan_log_model');
		$search['member_id'] = $this->login_lib->member_id();
		$total_rows = $this->Baodan_log_model->query_data_count($search);
		$html['pagination'] = html_pagination($page,$total_rows,$parameter);		
		$limit = html_limit($page);
		$html['maxnum'] = html_num($total_rows);
		$html['list'] = $this->Baodan_log_model->query_data($search,$limit);
		$this->load->view('/baodan_list',$html);
	}
}

/* End of file buy_free_currency.php */
/* Location: ./application/controllers/admin/buy_free_currency.php*/