<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sell_electronic_currency extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
 		fun_check_password2();
    }
	public function index($page=1,$parameter="")
	{
		$html=$this->init("出售电子积分","jquery,login");
		$id=$this->login_lib->member_id();
		$this->load->model('member_model');
		$html['row']=$this->member_model->get_row_byid($id);
		$html['collection_mode']=fun_collection_mode();
		$this->load->model('electronic_currency_market_model');
		$html['electronic_currency_market_count']=$this->electronic_currency_market_model->check_buyer_number($id);
		//echo $this->db->last_query();echo "<br/>";
		$this->load->view('/sell_electronic_currency',$html);
	}
	public function sell_submit(){
		$this->load->model('member_model');		
		$id=$this->login_lib->member_id();
		$member=$this->member_model->get_row_byid($id);
		$number=$this->input->post('number');
		$poundage=$this->input->post('poundage');
		if($member->electronic_currency>=$number){//+$poundage
			$return_result=$this->member_model->minus_electronic($number,$id);//+$poundage
			if($return_result>0){		
				$this->load->model('electronic_currency_market_model');
				$data['member_id']=$id;
				$data['user']=$this->input->post('user');
				$data['mobile']=$this->input->post('mobile');
				$data['bank']=$this->input->post('bank');
				$data['account']=$this->input->post('account');
				$data['name']=$this->input->post('name');
				$data['number']=$number;
				$data['poundage']=$poundage;
				$data['ymd']=date("Ymd");	
				$data['y']=date("Y");		
				$data['m']=date("m");		
				$data['d']=date("d");	
				$return_result=$this->electronic_currency_market_model->add($data);
				if($return_result>0){
					$this->session->set_flashdata('success_show', '挂单成功');
					redirect("sell_electronic_currency");
				}else{
					$this->session->set_flashdata('error_show', '挂单失败');
					redirect("sell_electronic_currency");
				}
			}else{
				$this->session->set_flashdata('error_show', '挂单失败');
				redirect("sell_electronic_currency");
			}
		}else{
			$this->session->set_flashdata('error_show', '电子积分不足挂单失败');
			redirect("sell_electronic_currency");
		}
	}
	
}

/* End of file sell_electronic_currency.php */
/* Location: ./application/controllers/sell_electronic_currency.php */