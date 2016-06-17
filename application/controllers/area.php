<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Area extends CI_Controller {
	function __construct()
    {
        parent::__construct();
    }

	function get_city($id = null){
		$this->load->model('area_model');
		$html['city'] = $this->area_model->get_parent_area($id);
		$this->load->view('get_city',$html);
	}

	function get_districty($id=null){
		$this->load->model('area_model');
		$html['district']=$this->area_model->get_parent_area($id);
		$this->load->view('get_districty',$html);
	}
}

/* End of file area.php */
/* Location: ./application/controllers/area.php */