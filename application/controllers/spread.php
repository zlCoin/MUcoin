<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Spread extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
    }
	public function index() {
		$html=$this->init("推广链接","jquery,login,validate");
		$id=$this->login_lib->member_id();
		$this->load->model('member_model');
		$html['row']=$this->member_model->get_row_byid($id);
		$this->load->view('/spread',$html);
	}
}

/* End of file spread.php */
/* Location: ./application/controllers/spread.php */