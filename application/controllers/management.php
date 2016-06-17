<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Management extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
    }
	public function index($page=1,$parameter="")
	{
		$html=$this->init("管理奖金","jquery,login");
		$this->load->model('management_model');
		$search['keyword']=$this->input->post('keyword');
		$search['member_id']=$this->login_lib->member_id();
		$html['keyword']=$search['keyword'];
		$total_rows = $this->management_model->query_data_groupbyymd_count($search);
		$html['pagination'] =html_pagination($page,$total_rows,$parameter);		
		$limit =html_limit($page);
		$html['maxnum']=html_num($total_rows);
		$html['list']=$this->management_model->query_data_groupbyymd($search,$limit);
		//echo $this->db->last_query();
		$this->load->view('/management_list',$html);
	}
	
}

/* End of file management.php */
/* Location: ./application/controllers/management.php */