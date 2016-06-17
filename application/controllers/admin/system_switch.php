<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class System_switch extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
    }
	public function index() {
		$html=$this->admin_init("开关设置","jquery,login,validate");		
		$this->load->model('system_switch_model');
		$html['row']=$this->system_switch_model->get_row_byid(1);
		$this->load->view('/admin/system_switch',$html);
	}
	public function set_submit(){
		$this->load->model('system_switch_model');
		$data['system']=$this->input->post('system');
		$data['electronic_currency']=$this->input->post('electronic_currency');
		$data['cash_currency']=$this->input->post('cash_currency');
		$data['free_currency']=$this->input->post('free_currency');
		$data['day_dividend']=$this->input->post('day_dividend');
		$return_result=$this->system_switch_model->update_data($data,1) ;
		if($return_result>0){				
			redirect("admin/system_switch");
		}else{
			redirect("admin/system_switch");
		}
	}	
}

/* End of file system_switch.php */
/* Location: ./application/controllers/admin/system_switch.php */