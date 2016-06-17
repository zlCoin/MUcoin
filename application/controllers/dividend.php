<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dividend extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
    }
	public function index($page=1,$parameter="")
	{
		$html=$this->init("积分赠送明细","jquery,login");
		$this->load->model('dividend_model');
		$search['keyword']=$this->input->post('keyword');
		$search['member_id']=$this->login_lib->member_id();
		$html['keyword']=$search['keyword'];
		$total_rows = $this->dividend_model->query_data_count($search);
		$html['pagination'] =html_pagination($page,$total_rows,$parameter);		
		$limit =html_limit($page);
		$html['maxnum']=html_num($total_rows);
		$html['list']=$this->dividend_model->query_data($search,$limit);
	//	echo $this->db->last_query();echo "<br/>";
		$this->load->view('/dividend_list',$html);
	}
	
}

/* End of file dividend.php */
/* Location: ./application/controllers/admin/dividend.php */