<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cash_currency_market extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
		fun_check_password2();
    }

	public function index($page=1,$parameter="")
	{
		$html=$this->init("现金积分市场","jquery,login");
		$this->load->model('cash_currency_market_model');
		$search['keyword']=$this->input->post('keyword');
		$html['keyword']=$search['keyword'];
		$total_rows = $this->cash_currency_market_model->query_data_state_count($search);
		if($total_rows>200)
			$total_rows=200;
		$html['pagination'] =html_pagination1($page,$total_rows,$parameter);		
		$limit =html_limit1($page);
		$html['maxnum']=html_num($total_rows);
		$html['list']=$this->cash_currency_market_model->query_data_state($search,$limit);		
		$search['member_id']=$this->login_lib->member_id();	
		$html['member_id']=$search['member_id'];
		$html['member_transfer0']=$this->cash_currency_market_model->query_data_member($search,1,"10,0");
		$html['member_transfer1']=$this->cash_currency_market_model->query_data_buyer($search,"10,0");
		$html['cash_currency_market_state']=fun_electronic_currency_market_state();
		$this->load->view('/cash_currency_market',$html);
	}
	
	public function buy($id){		
		$this->load->model('member_model');
		$member_id=$this->login_lib->member_id();
		if($member_id!="" && $id!=""){
			$member=$this->member_model->get_row_byid($member_id);			
			$this->load->model('cash_currency_market_model');
			$data['buyer_id']=$member_id;
			$data['buyer_user']=$member->user;
			$data['buyer_mobile']=$member->mobile;
			$data['btime']=time();
			$data['state']=1;
			$return_result=$this->cash_currency_market_model->update_data($data,$id);
			if($return_result>0){
				$this->session->set_flashdata('success_show', '购买成功');
				redirect("cash_currency_market");
			}else{
				$this->session->set_flashdata('error_show', '购买失败');
				redirect("cash_currency_market");
			}
		}else{
			$this->session->set_flashdata('error_show', '购买失败');
			redirect("cash_currency_market");
		}
	}
	public function cancel($id){		
		$this->load->model('member_model');
		$member_id=$this->login_lib->member_id();
		if($member_id!="" && $id!=""){			
			$this->load->model('cash_currency_market_model');
			$cash_currency_market=$this->cash_currency_market_model->get_row_byid($id);
			if($cash_currency_market->member_id==$member_id){
				$return_result=$this->member_model->add_cash($cash_currency_market->number,$member_id);	//+$cash_currency_market->poundage
				if($return_result>0){				
					$return_result=$this->cash_currency_market_model->delete_byid($id);
						if($return_result){
					       $this->session->set_flashdata('success_show', '取消成功');
							redirect("cash_currency_market");
						}else{							
					       $this->session->set_flashdata('error_show', '取消失败');
							redirect("cash_currency_market");
						}
				}else{
					$this->session->set_flashdata('error_show', '取消失败');
					redirect("cash_currency_market");
				}
			}else{
				$this->session->set_flashdata('error_show', '取消失败');
				redirect("cash_currency_market");
			}
		}else{
			$this->session->set_flashdata('error_show', '取消失败');
			redirect("cash_currency_market");
		}
	}
	public function undo($id){		
		$this->load->model('member_model');
		$member_id=$this->login_lib->member_id();
		if($member_id!="" && $id!=""){			
			$this->load->model('cash_currency_market_model');
			$cash_currency_market=$this->cash_currency_market_model->get_row_byid($id);
			if($cash_currency_market->member_id==$member_id){						
					$data['buyer_id']=0;
					$data['buyer_user']="";
					$data['buyer_mobile']="";
					$data['btime']=0;
					$data['state']=0;
					$return_result=$this->cash_currency_market_model->update_data($data,$id);
					if($return_result>0){		
					    $this->session->set_flashdata('success_show', '撤消成功');
						redirect("cash_currency_market");
					}else{
						$this->session->set_flashdata('error_show', '撤消失败');
						redirect("cash_currency_market");
					}
			}else{
				$this->session->set_flashdata('error_show', '撤消失败');
				redirect("cash_currency_market");
			}
		}else{
			$this->session->set_flashdata('error_show', '撤消失败');
			redirect("cash_currency_market");
		}
	}
	public function confirm($id){				
		$this->load->model('member_model');
		if($id!=""){	
			$this->load->model('cash_currency_market_model');
			$data['cftime']=time();
			$data['state']=2;
			$return_result=$this->cash_currency_market_model->update_data($data,$id);
			if($return_result>0){
				$cash_currency_market=$this->cash_currency_market_model->get_row_byid($id);
				$cash=$cash_currency_market->number-$cash_currency_market->poundage;
				$return_result=$this->member_model->add_electronic($cash,$cash_currency_market->buyer_id);
				if($return_result>0){
					$this->load->model('cash_model');
					$cash_data['member_id']=$cash_currency_market->member_id;		
					$cash_data['user']=$cash_currency_market->user;						
					$cash_data['to_member_id']=$cash_currency_market->buyer_id;					
					$cash_data['to_user']=$cash_currency_market->buyer_user;				
					//$cash_data['to_name']=$cash_currency_market->name;				
					$cash_data['type']="sell_cash";				
					$cash_data['cash_currency']="-".$cash_currency_market->number;		
					$cash_data['ymd']=date("Ymd");	
					$cash_data['y']=date("Y");		
					$cash_data['m']=date("m");		
					$cash_data['d']=date("d");						
					$return_result=$this->cash_model->add($cash_data);
					$this->load->model('electronic_model');
					$electronic_data2['member_id']=$cash_currency_market->buyer_id;			
					$electronic_data2['user']=$cash_currency_market->buyer_user;								
					$electronic_data2['from_member_id']=$cash_currency_market->member_id;				
					$electronic_data2['from_user']=$cash_currency_market->user;			
					$electronic_data2['type']="cash_currency_market";
					$electronic_data2['transfer']=1;		
					$electronic_data2['electronic_currency']=$cash;			
					$electronic_data2['from_electronic_currency']=$cash_currency_market->number;		
					$electronic_data2['ymd']=date("Ymd");	
					$electronic_data2['y']=date("Y");		
					$electronic_data2['m']=date("m");		
					$electronic_data2['d']=date("d");	
					$return_result=$this->electronic_model->add($electronic_data2); 
				}				
				$this->session->set_flashdata('success_show', '确定成功');
				redirect("cash_currency_market");
			}else{
				$this->session->set_flashdata('error_show', '确定失败');
				redirect("cash_currency_market");
			}
		}else{
			$this->session->set_flashdata('error_show', '确定失败');
			redirect("cash_currency_market");
		}
	}
}

/* End of file cash_currency_market.php */
/* Location: ./application/controllers/cash_currency_market.php */