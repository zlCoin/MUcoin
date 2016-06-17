<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller {
	function __construct()
    {
        parent::__construct();
    }

	public function index()
	{
		$html = $this->admin_init("首页","jquery,layer");
		$this->load->model('member_model');
		$this->load->model('free_currency_model');
		$this->load->model('cash_model');
		$this->load->model('recharge_model');
		$html['member_count'] = $this->member_model->current_member_count();
		$html['member_free'] = $this->free_currency_model->get_current_free_all();
		$html['member_cash'] = $this->cash_model->get_current_cash_all() + $this->recharge_model->get_current_recharge_all();
		$this->load->view('admin/index',$html);
	}
}

/* End of file index.php */
/* Location: ./application/controllers/admin/index.php */