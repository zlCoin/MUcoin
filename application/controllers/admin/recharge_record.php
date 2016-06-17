<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Recharge_record extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
    }
	public function index($page=1,$parameter="")
	{
		$html=$this->admin_init("充值记录","jquery,login");
		$this->load->model('recharge_model');
		$search['keyword']=$this->input->post('keyword');
		$html['keyword']=$search['keyword'];
		$total_rows = $this->recharge_model->query_data_count($search);
		$html['pagination'] =html_pagination($page,$total_rows,$parameter);		
		$limit =html_limit($page);
		$html['maxnum']=html_num($total_rows);
		$html['list']=$this->recharge_model->query_data($search,$limit);
		$this->load->view('/admin/recharge_record_list',$html);
	}
}

/* End of file recharge_record.php */
/* Location: ./application/controllers/admin/recharge_record.php */