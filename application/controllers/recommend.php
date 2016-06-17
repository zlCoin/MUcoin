<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Recommend extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
    }
	public function index($page=1,$parameter="")
	{
		$html=$this->init("推荐奖金","jquery,login");
		$this->load->model('recommend_model');
		$search['keyword']=$this->input->post('keyword');
		$search['member_id']=$this->login_lib->member_id();
		$html['keyword']=$search['keyword'];
		$total_rows = $this->recommend_model->query_data_count($search);
		$html['pagination'] =html_pagination($page,$total_rows,$parameter);		
		$limit =html_limit($page);
		$html['maxnum']=html_num($total_rows);
		$html['list']=$this->recommend_model->query_data($search,$limit);
	//	echo $this->db->last_query();echo "<br/>";
		$this->load->view('/recommend_list',$html);
	}
	
}

/* End of file recommend.php */
/* Location: ./application/controllers/admin/recommend.php */