<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pay extends CI_Controller {
	function __construct()
    {
        parent::__construct();
    }

	public function payment($id){		
		$this->load->library("cai1pay");
		$this->load->model("pay_model");
		$data=$this->pay_model->get_row_byid($id);
		$this->cai1pay-> pay($data);
	}
	public function notify_url()
	{
		$this->load->library("cai1pay");
		$this->cai1pay->notify_url();
	}
	public function return_url()
	{
		$this->load->library("cai1pay");
		$this->cai1pay->return_url();
	}

	public function success($id=null){
			
		$html=$this->init("支付成功","jquery,validate");		
		$this->load->model('pay_model');			
		$html['pay']=$this->pay_model->get_row_byid($id);			
		$this->load->model('member_model');
		$html['row']=$this->member_model->get_row_byid($html['pay']->member_id);
		if($html['pay']->state==1){
			$this->session->set_userdata('expiration_date',$html['row']->expiration_date);
		}
		$this->load->view('pay_success',$html);
	}

	public function fail($type=null){
		$html=$this->init("支付失败","jquery,validate");		
		$this->load->view('pay_fail',$html);
	}
}

/* End of file pay.php */
/* Location: ./application/controllers/pay.php */