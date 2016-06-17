<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Electronic_get extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
		fun_check_expiration_date2();
    }
	public function index($page=1,$parameter="")
	{
		$html=$this->init("电子积分获得记录","jquery,login");
		$this->load->model('electronic_model');
		$search['keyword']=$this->input->post('keyword');
		$search['member_id']=$this->login_lib->member_id();
		$html['keyword']=$search['keyword'];
		$html['member_id']=$search['member_id'];
		$total_rows = $this->electronic_model->query_data_get_count($search);
		$html['pagination'] =html_pagination($page,$total_rows,$parameter);		
		$limit =html_limit($page);
		$html['maxnum']=html_num($total_rows);
		$html['list']=$this->electronic_model->query_data_get($search,$limit);
		$html['electronic_type']=fun_electronic_type();
		$this->load->view('/electronic_get',$html);
	}
	
}

/* End of file electronic_get.php */
/* Location: ./application/controllers/admin/electronic_get.php */