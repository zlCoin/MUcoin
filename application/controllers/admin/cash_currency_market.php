<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cash_currency_market extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
    }
	public function index($page=1,$parameter="")
	{
		$html=$this->admin_init("现金积分市场管理","jquery,login");
		$this->load->model('cash_currency_market_model');
		$search['keyword']=$this->input->post('keyword');
		$html['keyword']=$search['keyword'];
		$total_rows = $this->cash_currency_market_model->query_data_count($search);
		$html['pagination'] =html_pagination($page,$total_rows,$parameter);		
		$limit =html_limit($page);
		$html['maxnum']=html_num($total_rows);
		$html['list']=$this->cash_currency_market_model->query_data($search,$limit);
		$html['cash_currency_market_state']=fun_cash_currency_market_state();
		$this->load->view('/admin/cash_currency_market',$html);
	}
	
	public function cancel($id){		
			$this->load->model('member_model');
			$this->load->model('cash_currency_market_model');
			$cash_currency_market=$this->cash_currency_market_model->get_row_byid($id);
			//$return_result=$this->member_model->add_cash($cash_currency_market->number+$cash_currency_market->poundage,$cash_currency_market->member_id);	
			//comments by caiqian , 后台取消挂单,回退挂单金额即可.			
			$return_result=$this->member_model->add_cash($cash_currency_market->number,$cash_currency_market->member_id);		
			
			if($return_result>0){				
				$return_result=$this->cash_currency_market_model->delete_byid($id);
				if($return_result){
					redirect("admin/cash_currency_market");
				}else{							
					redirect("admin/cash_currency_market");
				}
				redirect("admin/cash_currency_market");
			}
	}
}

/* End of file cash_currency_market.php */
/* Location: ./application/controllers/admin/cash_currency_market.php */