<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Free_currency_market extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
    }
	public function index($page=1,$parameter="")
	{
		$html=$this->admin_init("自由积分市场管理","jquery,login");
		$this->load->model('free_currency_market_model');
		$search['keyword']=$this->input->post('keyword');
		$html['keyword']=$search['keyword'];
		$total_rows = $this->free_currency_market_model->query_data_count($search);
		$html['pagination'] =html_pagination($page,$total_rows,$parameter);		
		$limit =html_limit($page);
		$html['maxnum']=html_num($total_rows);
		$html['list']=$this->free_currency_market_model->query_data($search,$limit);
		$html['free_currency_market_state']=fun_free_currency_market_state();
		$this->load->view('/admin/free_currency_market',$html);
	}
	
	public function cancel($id){		
			$this->load->model('member_model');
			$this->load->model('free_currency_market_model');
			$free_currency_market=$this->free_currency_market_model->get_row_byid($id);
			$return_result=$this->member_model->add_free_currency($free_currency_market->number+$free_currency_market->poundage,$free_currency_market->member_id);	
			if($return_result>0){				
				$return_result=$this->free_currency_market_model->delete_byid($id);
				if($return_result){
					redirect("admin/free_currency_market");
				}else{							
					redirect("admin/free_currency_market");
				}
				redirect("admin/free_currency_market");
			}
	}
}

/* End of file free_currency_market.php */
/* Location: ./application/controllers/admin/free_currency_market.php */