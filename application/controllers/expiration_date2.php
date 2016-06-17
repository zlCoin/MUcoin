<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Expiration_date2 extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
    }
	public function check($page) {
		$html=$this->init("账户欠费","jquery,login,validate");
		$id=$this->login_lib->member_id();
		$this->load->model('member_model');
		$html['row']=$this->member_model->get_row_byid($id);
		$html['page']=$page;
		$this->load->view('/expiration_date2',$html);
	}
	
}

/* End of file expiration_date2.php */
/* Location: ./application/controllers/expiration_date2.php */