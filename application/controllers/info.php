<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Info extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
    }
	public function index() {
		$html=$this->init("账户资料","jquery,login,validate");
		$id=$this->login_lib->member_id();
		$this->load->model('member_model');
		$html['row']=$this->member_model->get_row_byid($id);
		$this->load->view('/info',$html);
	}
}

/* End of file info.php */
/* Location: ./application/controllers/info.php */