<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sell_free_currency extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
    }
	public function index($page=1,$parameter="")
	{
		$html=$this->init("出售自由积分","jquery,login");
		$id=$this->login_lib->member_id();
		$this->load->model('member_model');
		$html['row']=$this->member_model->get_row_byid($id);
		$this->load->model('system_free_currency_model');
		$html['system_free_currency']=$this->system_free_currency_model->get_row_data();
		$this->load->view('/sell_free_currency',$html);
	}
	public function sell_submit(){
		$this->load->model('member_model');		
		$id=$this->login_lib->member_id();
		$member=$this->member_model->get_row_byid($id);
		$number=$this->input->post('number');
		if($member->free_currency>=$number){
			$return_result=$this->member_model->minus_free_currency($number,$id);
			if($return_result>0){		
				$this->load->model('free_currency_market_model');
				$data['member_id']=$id;
				$data['user']=$this->input->post('user');
				$data['number']=$number;
				$data['price']=$this->input->post('price');
				$data['ymd']=date("Ymd");	
				$data['y']=date("Y");		
				$data['m']=date("m");		
				$data['d']=date("d");	
				if($data['number']!=""){
					$return_result=$this->free_currency_market_model->add($data);
					if($return_result>0){
						redirect("free_currency_market");
					}else{
						echo "1";

					//	redirect("sell_free_currency");
					}
				}else{
						echo "2";
					//redirect("sell_free_currency");
				}			
			}else{
						echo "3";
				//redirect("sell_free_currency");
			}
		}else{
						echo "4";
			//redirect("sell_free_currency");
		}
	}
	
}

/* End of file sell_free_currency.php */
/* Location: ./application/controllers/sell_free_currency.php */