<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cash extends CI_Controller {

	function __construct(){
		parent::__construct();
        fun_check_member_state();	// 限制激活操作
	}

	public function index($page=1,$parameter=""){
		$html = $this->init("奖金积分市场","jquery,login");
		$this->load->model('cash_model');
		$search['keyword'] = $this->input->post('keyword');
		$search['member_id'] = $this->login_lib->member_id();
		$html['keyword'] = $search['keyword'];
		$total_rows = $this->cash_model->query_data_count($search);
		$html['pagination'] = html_pagination($page,$total_rows,$parameter);		
		$limit = html_limit($page);
		$html['maxnum'] = html_num($total_rows);
		$html['list'] = $this->cash_model->query_data($search,$limit);
		$html['cash_type'] = fun_cash_type();
		$this->load->view('/cash_list',$html);
	}
}

/* End of file cash.php */
/* Location: ./application/controllers/admin/cash.php */