<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Electronic_currency_transfer extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
    }
	public function index($page=1,$parameter="")
	{
		$html=$this->admin_init("电子积分转账记录","jquery,login");
		$this->load->model('electronic_model');
		$search['keyword']=$this->input->post('keyword');
		$search['type']="electronic_to_electronic";
		$html['keyword']=$search['keyword'];
		$total_rows = $this->electronic_model->query_data_transfer_count($search);
		$html['pagination'] =html_pagination($page,$total_rows,$parameter);		
		$limit =html_limit($page);
		$html['maxnum']=html_num($total_rows);
		$html['list']=$this->electronic_model->query_data_transfer($search,$limit);
		$this->load->view('/admin/electronic_currency_transfer',$html);
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
					$this->load->model('electronic_model');
					$electronic_data['member_id']=$electronic_currency_market->member_id;		
					$electronic_data['user']=$electronic_currency_market->user;						
					$electronic_data['to_member_id']=$electronic_currency_market->buyer_id;					
					$electronic_data['to_user']=$electronic_currency_market->buyer_user;				
					//$electronic_data['to_name']=$electronic_currency_market->name;				
					$electronic_data['type']="sell_electronic";
					$electronic_data['electronic_currency']=$electronic_currency_market->number;		
					$electronic_data['to_electronic_currency']=$electronic_currency_market->number;	
					$electronic_data['ymd']=date("Ymd");	
					$electronic_data['y']=date("Y");		
					$electronic_data['m']=date("m");		
					$electronic_data['d']=date("d");						
					$return_result=$this->electronic_model->add($electronic_data);
					$electronic_data2['member_id']=$electronic_currency_market->buyer_id;			
					$electronic_data2['user']=$electronic_currency_market->buyer_user;								
					$electronic_data2['from_member_id']=$electronic_currency_market->member_id;				
					$electronic_data2['from_user']=$electronic_currency_market->user;						
					//$electronic_data2['from_name']=$member->name;			
					$electronic_data2['type']="buy_electronic";
					$electronic_data2['transfer']=1;		
					$electronic_data2['electronic_currency']=$electronic_currency_market->number;			
					$electronic_data2['from_electronic_currency']=$electronic_currency_market->number;		
					$electronic_data2['ymd']=date("Ymd");	
					$electronic_data2['y']=date("Y");		
					$electronic_data2['m']=date("m");		
					$electronic_data2['d']=date("d");	
					$return_result=$this->electronic_model->add($electronic_data2); 
					$this->session->set_flashdata('success_show', '确定成功');
					redirect("electronic_currency_market");
				}else{
					$this->session->set_flashdata('error_show', '确定失败');
					redirect("electronic_currency_market");
				}
					      
			}else{
					$this->session->set_flashdata('error_show', '确定失败');
				redirect("electronic_currency_market");
			}
		}else{
					$this->session->set_flashdata('error_show', '确定失败');
			redirect("electronic_currency_market");
		}
	}

	
}

/* End of file electronic_currency_transfer.php */
/* Location: ./application/controllers/admin/electronic_currency_transfer.php */