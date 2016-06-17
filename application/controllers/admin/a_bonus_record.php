<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class A_bonus_record extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
    }
	public function index($page=1,$parameter="")
	{
		date_default_timezone_set("Asia/Shanghai"); 
		$html=$this->admin_init("积分赠送记录","jquery,login");
		$this->load->model('a_bonus_model');
		$search['keyword']=$this->input->post('keyword');
		$html['keyword']=$search['keyword'];
		$total_rows = $this->a_bonus_model->query_data_count($search);
		$html['pagination'] =html_pagination($page,$total_rows,$parameter);		
		$limit =html_limit($page);
		$html['maxnum']=html_num($total_rows);
		$html['list']=$this->a_bonus_model->query_data($search,$limit);

        // var_dump($html['list']);

		$this->load->view('/admin/a_bonus_record',$html);
	}
}

/* End of file a_bonus_record.php */
/* Location: ./application/controllers/admin/a_bonus_record.php */