<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class System_set extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
    }
    
	public function index() {
		$html = $this->admin_init("参数设置","jquery,login,validate");		
		$this->load->model('system_set_model');
		$html['row']=$this->system_set_model->get_row_byid(1);
		$this->load->view('/admin/system_set',$html);
	}

	public function set_submit(){
		$this->load->model('system_set_model');
		$id = 1;
		$data['invest_limit']=$this->input->post('invest_limit');
		$data['bonus']=$this->input->post('bonus');
		$data['day_dividend']=$this->input->post('day_dividend');
		$data['dividend_time']=$this->input->post('dividend_time');
		$data['cap_amount']=$this->input->post('cap_amount');
		$data['stock_limit']=$this->input->post('stock_limit');
		$data['rmb']=$this->input->post('rmb');
		$return_result=$this->system_set_model->update_data($data,1) ;
		if($return_result>0){				
			redirect("admin/system_set");
		}else{
			redirect("admin/system_set");
		}
	}	
}

/* End of file system_set.php */
/* Location: ./application/controllers/admin/system_set.php */