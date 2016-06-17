<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Management_fees extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
    }
	public function index($page=1,$parameter="")
	{
		$html=$this->init("缴纳管理费","jquery,login,validate");			
		$id=$this->login_lib->member_id();
		$this->load->model('member_model');
		$html['row']=$this->member_model->get_row_byid($id);
		$this->load->model('system_set_model');
		$html['system_set']=$this->system_set_model->get_row_byid(1);
		$this->load->model('pay_model');
		$search['keyword']=$this->input->post('keyword');
		$search['member_id']=$id;
		$html['keyword']=$search['keyword'];
		$total_rows = $this->pay_model->query_data_count($search);
		$html['pagination'] =html_pagination($page,$total_rows,$parameter);		
		$limit =html_limit($page);
		$html['maxnum']=html_num($total_rows);
		$html['list']=$this->pay_model->query_data($search,$limit);
		$this->load->view('/management_fees',$html);
	}
	public function pay_submit()
	{
		$this->load->model('member_model');
		$id=$this->login_lib->member_id();
		$member=$this->member_model->get_row_byid($id);
		$this->load->model('system_set_model');
		$system_set=$this->system_set_model->get_row_byid(1);
		$money=$this->input->post('money');
		if($id!="" && $money!=""){
					$this->load->model('pay_model');
					$pay_data['member_id']=$member->member_id;
					$pay_data['user']=$member->user;
					$pay_data['money']=$money;					
					$pay_data['number']=$money/100*30;
					$pay_data['relation_id']=1;
					$pay_data['remark']="缴纳管理费";
					$pay_data['state']=0;
			        $return_result_pay=$this->pay_model->add($pay_data);
					if($return_result_pay>0){	
							$update_data['no']=date("Ymdhis").substr(strval($return_result_pay+10000000),1,7);	
							$this->pay_model->update_data($update_data,$return_result_pay);	
							redirect("/pay/payment/". $return_result_pay);			
					}
		}else{
			redirect("management_fees");
		}
	}
}

/* End of file management_fees.php */
/* Location: ./application/controllers/management_fees.php */