<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Buy_free_currency extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
    }
	public function index($page=1,$parameter="")
	{
		$html=$this->init("购买积分","jquery,login");
		$id=$this->login_lib->member_id();
		$this->load->model('system_free_currency_model');
		$system_free_currency=$this->system_free_currency_model->get_row_data();
        // echo ($system_free_currency['free_currency']);
		//$html['system_free_currency']=$system_free_currency->free_currency;
		//$html['system_free_currency_price']=$system_free_currency->price;
		$this->load->model('member_model');
		$html['row']=$this->member_model->get_row_byid($id);
		
		$this->load->view('/buy_free_currency',$html);
	}
	public function buy_submit(){
		$this->load->model('member_model');		
		$id=$this->login_lib->member_id();
		$member=$this->member_model->get_row_byid($id);
		$number=$this->input->post('number');
		$this->load->model('system_free_currency_model');
		$system_free_currency=$this->system_free_currency_model->get_row_data();
		if($member->free_gold>=$number*$system_free_currency->price){
			$return_result=$this->member_model->free_gold_buy_free_currency($number,$system_free_currency->price,$id);
			//echo $this->db->last_query();die();
			if($return_result>0){		
				$this->load->model('free_gold_model');
				$data['member_id']=$this->login_lib->member_id();
				$data['user']=$member->user;
				$data['free_gold']=$number*$system_free_currency->price;
				$data['free_currency']=$number;
				$data['price']=$system_free_currency->price;
				$data['balance']=$member->free_gold-$number;
				$data['ymd']=date("Ymd");	
				$data['y']=date("Y");		
				$data['m']=date("m");		
				$data['d']=date("d");	
				if($data['number']!=""){
					$return_result=$this->free_gold_model->add($data);
					if($return_result>0){
						redirect("buy_free_currency");
					}else{
						redirect("buy_free_currency");
					}
				}else{
					redirect("buy_free_currency");
				}			
			}else{
				redirect("buy_free_currency");
			}
		}else{
			redirect("buy_free_currency");
		}
	}
	
}

/* End of file buy_free_currency.php */
/* Location: ./application/controllers/admin/buy_free_currency.php*/