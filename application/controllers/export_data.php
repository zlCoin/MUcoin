<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Export_data extends CI_Controller {

	function __construct()
    {
        parent::__construct();
    }
	public function index($page=1,$parameter="")
	{
		$html=$this->init("导出数据","jquery,login");
		$this->load->view('/export_data',$html);
	}
	public function data_submit(){
		
	}
	
}

/* End of file export_data.php */
/* Location: ./application/controllers/export_data.php */