<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {
	function __construct()
    {
        parent::__construct();
    }
	public function index()
	{
		$html = $this->init("首页","jquery,layer");
		$this->load->model('notice_model');
		$html['notice']=$this->notice_model->get_data_bylimit("9,0");
		$this->load->model('help_model');
		$html['help']=$this->help_model->get_data_bylimit("9,0");
		$id=$this->login_lib->member_id();
		$this->load->model('member_model');
		$html['member']=$this->member_model->get_row_byid($id);
		$this->load->view('main',$html);
	}
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */