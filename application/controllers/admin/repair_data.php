<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Repair_data extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
    }
	public function index() {
		$html=$this->admin_init("修复数据","jquery,login,validate");		
		$this->load->view('/admin/repair_data',$html);
	}

	public function shop(){
			$this->load->model('ecs_users_model');
			$member_list=$this->ecs_users_model->get_data();
			foreach($member_list as $key=>$row){
				$this->ecs_users_model->add($row->user,$row->password,$row->mobile,$row->email);
				echo $this->db->last_query();echo "<br/>";die();
			}
	}
}

/* End of file repair_data.php */
/* Location: ./application/controllers/admin/repair_data.php */