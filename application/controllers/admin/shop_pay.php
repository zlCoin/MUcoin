<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shop_pay extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
    }
	public function index($page=1,$parameter="")
	{
		$html=$this->admin_init("商城帐单","jquery,login");
		$this->load->model('shop_pay_model');
		$search['keyword']=$this->input->post('keyword');
		$html['keyword']=$search['keyword'];
		$total_rows = $this->shop_pay_model->query_data_count($search);
		$html['pagination'] =html_pagination($page,$total_rows,$parameter);		
		$limit =html_limit($page);
		$html['maxnum']=html_num($total_rows);
		$html['list']=$this->shop_pay_model->query_data($search,$limit);
		$this->load->view('/admin/shop_pay_list',$html);
	}
	public function confirm($id){			
		$this->load->model('shop_pay_model');
		$row=$this->shop_pay_model->get_row_byid($id);
		if($row->state==0){			
			$this->load->model('member_model');
			$return_result=$this->member_model->add_cash($row->shopping_currency,$row->member_id);	
			if($return_result>0){		
				$data['cftime']=time();
				$data['state']=1;
				$this->shop_pay_model->update_data($data,$row->member_id);
			}else{							
				redirect("admin/shop_pay");
			}
		}else{							
			redirect("admin/shop_pay");
		}
	}	

	public function payment($id){
		$html=$this->admin_init("付款","jquery,login,validate");			
		$this->load->model('shop_pay_model');
		$html['row']=$this->shop_pay_model->get_row_byid($id);
		$this->load->model('member_model');
		$html['member']=$this->member_model->get_row_byid($html['row']->member_id);
		$this->config->load('cai1pay', TRUE);
        $html['config'] = $this->config->item('cai1pay');
		$this->load->view('/admin/shop_pay_payment',$html);
	}
}

/* End of file shop_pay_list.php */
/* Location: ./application/controllers/admin/shop_pay_list.php */