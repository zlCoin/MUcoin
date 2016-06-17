<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Back_up extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
    }
	public function index() {
		$html=$this->admin_init("系统备份","jquery,login,validate");		
		$this->load->view('/admin/back_up',$html);
	}
}

/* End of file back_up.php */
/* Location: ./application/controllers/admin/back_up.php */