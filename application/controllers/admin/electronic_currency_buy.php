<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Electronic_currency_buy extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
    }
	public function index($page=1,$parameter="")
	{
		$html=$this->admin_init("卖出电子积分管理","jquery,login");
		$this->load->model('electronic_model');
		$search['keyword']=$this->input->post('keyword');
		$search['type']="electronic_currency_buy";
		$html['keyword']=$search['keyword'];
		$total_rows = $this->electronic_model->query_data_count($search);
		$html['pagination'] =html_pagination($page,$total_rows,$parameter);		
		$limit =html_limit($page);
		$html['maxnum']=html_num($total_rows);
		$html['list']=$this->electronic_model->query_data($search,$limit);
		$this->load->view('/admin/electronic_currency_buy',$html);
	}

	
}

/* End of file electronic_currency_buy.php */
/* Location: ./application/controllers/admin/electronic_currency_buy.php */