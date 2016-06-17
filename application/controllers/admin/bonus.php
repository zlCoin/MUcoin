<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bonus extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
    }
	public function index($page=1,$parameter="")
	{
		$html=$this->admin_init("奖金明细","jquery,login");
		$this->load->model('bonus_model');
		$search['keyword']=$this->input->post('keyword');
		$html['keyword']=$search['keyword'];
		$total_rows = $this->bonus_model->query_data_count($search);
		$html['pagination'] =html_pagination($page,$total_rows,$parameter);		
		$limit =html_limit($page);
		$html['maxnum']=html_num($total_rows);
		$html['list']=$this->bonus_model->query_data($search,$limit);
		$this->load->view('/admin/bonus_list',$html);
	}

	
}

/* End of file bonus.php */
/* Location: ./application/controllers/admin/bonus.php */