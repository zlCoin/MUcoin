<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Activation_code_bill extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
    }
	public function index($page=1,$parameter="")
	{
		$html=$this->admin_init("充值卡密码帐单","jquery,login");
		$this->load->model('activation_code_model');
		$search['keyword']=$this->input->post('keyword');
		$search['state']=1;
		$html['keyword']=$search['keyword'];
		$total_rows = $this->activation_code_model->query_data_count($search);
		$html['pagination'] =html_pagination($page,$total_rows,$parameter);		
		$limit =html_limit($page);
		$html['maxnum']=html_num($total_rows);
		$html['list']=$this->activation_code_model->query_data($search,$limit);
		$this->load->view('/admin/activation_code_bill',$html);
	}
}

/* End of file activation_code_bill.php */
/* Location: ./application/controllers/admin/activation_code_bill.php */