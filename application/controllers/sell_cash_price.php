<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sell_cash_price extends CI_Controller {
	
	function __construct(){
        parent::__construct();
        fun_check_member_state();	// 限制激活操作
		fun_check_password2();
    }
    
	public function index($page=1,$parameter=""){
		$html=$this->init("购买积分","jquery,login");
		$this->load->view('/sell_cash_price',$html);
	}
}

/* End of file sell_cash_currency.php */
/* Location: ./application/controllers/sell_cash_currency.php */