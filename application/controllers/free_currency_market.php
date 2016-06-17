<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Free_currency_market extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
		fun_check_password2();
    }
	public function index($page=1,$parameter="")
	{
		$html=$this->init("自由积分市场","jquery,login");
		$this->load->model('free_currency_market_model');
		$search['keyword']=$this->input->post('keyword');
		$search['member_id']=$this->login_lib->member_id();
		$html['keyword']=$search['keyword'];
		$html['member_id']=$search['member_id'];
		$total_rows = $this->free_currency_market_model->query_data_count($search);
		$html['pagination'] =html_pagination($page,$total_rows,$parameter);		
		$limit =html_limit($page);
		$html['maxnum']=html_num($total_rows);
		$html['list']=$this->free_currency_market_model->query_data($search,$limit);
		$this->load->model('system_free_currency_model');
		$html['system_free_currency']=$this->system_free_currency_model->get_row_data();
		$this->load->model('system_free_currency_dynamic_model');
		$html['system_free_currency_dynamic']=$this->system_free_currency_dynamic_model->get_row_data();
		$this->load->view('/free_currency_market',$html);
	}
	
	public function buy($id){		
		$this->load->model('free_currency_market_model');
		$member_id=$this->login_lib->member_id();
		if($member_id!="" && $id!=""){
			$free_currency_market=$this->free_currency_market_model->get_row_byid($id);
			$member=$this->member_model->get_row_byid($member_id);
			$data['buyer_id']=$member_id;
			$data['buyer_user']=$member->user;
			$data['btime']=time();
			$data['state']=1;
			$return_result=$this->free_currency_market_model->update_data($data,$id);
			if($return_result>0){				
				$this->load->model('system_free_currency_dynamic_model');
				$this->system_free_currency_dynamic_model->update_dynamic($free_currency_market->buy_number);
				redirect("free_currency_market");
			}else{
				redirect("free_currency_market");
			}
		}else{
			redirect("free_currency_market");
		}
	}

	public function confirm($id){				
		$this->load->model('member_model');
		if($id!=""){	
			$this->load->model('electronic_currency_market_model');
			$data['cftime']=time();
			$data['state']=2;
			$return_result=$this->electronic_currency_market_model->update_data($data,$id);
			if($return_result>0){
				$electronic_currency_market=$this->electronic_currency_market_model->get_row_byid($id);
				$return_result=$this->member_model->add_electronic($electronic_currency_market->number,$electronic_currency_market->buyer_id);
				if($return_result>0){
					
				}
				redirect("electronic_currency_market");
			}else{
				redirect("electronic_currency_market");
			}
		}else{
			redirect("electronic_currency_market");
		}
	}
}

/* End of file free_currency_market.php */
/* Location: ./application/controllers/free_currency_market.php */