<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class report_daily_report extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
    }
	public function index($page=1,$parameter="")
	{
		$html=$this->admin_init("充值卡密码","jquery,login");

		$this->load->view('/admin/report_daily_report_view',$html);
	}


}

/* End of file activation_code.php */
/* Location: ./application/controllers/admin/activation_code.php */