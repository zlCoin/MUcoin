<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bonus extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
    }
	public function index($page=1,$parameter="")
	{
		$html=$this->init("奖金总览","jquery,login");
		$this->load->model('bonus_model');
		$search['keyword']=$this->input->post('keyword');
		$search['member_id']=$this->login_lib->member_id();
		$html['keyword']=$search['keyword'];
		$total_rows = $this->bonus_model->query_data_groupbyymd_count($search);
		$html['pagination'] =html_pagination($page,$total_rows,$parameter);		
		$limit =html_limit($page);
		$html['maxnum']=html_num($total_rows);
		$html['list']=$this->bonus_model->query_data_groupbyymd($search,$limit);
		$this->load->view('/bonus_list',$html);
	}
	
}

/* End of file bonus.php */
/* Location: ./application/controllers/admin/bonus.php */