<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Electronic_currency_market extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
		fun_check_expiration_date2();
		fun_check_password2();
    }
	public function index($page=1,$parameter="")
	{
		$html=$this->init("电子积分市场","jquery,login");
		$this->load->model('electronic_currency_market_model');
		$search['keyword']=$this->input->post('keyword');
		$html['keyword']=$search['keyword'];
		$total_rows = $this->electronic_currency_market_model->query_data_state_count($search);
		$html['pagination'] =html_pagination1($page,$total_rows,$parameter);		
		$limit =html_limit1($page);
		$html['maxnum']=html_num($total_rows);
		$html['list']=$this->electronic_currency_market_model->query_data_state($search,$limit);		
		$search['member_id']=$this->login_lib->member_id();	
		$html['member_id']=$search['member_id'];
		$html['member_transfer0']=$this->electronic_currency_market_model->query_data_member($search,1,"10,0");
		$html['member_transfer1']=$this->electronic_currency_market_model->query_data_buyer($search,"10,0");
		$html['electronic_currency_market_state']=fun_electronic_currency_market_state();
		$this->load->view('/electronic_currency_market',$html);
	}
	
	public function buy($id){		
		$this->load->model('member_model');
		$member_id=$this->login_lib->member_id();
		if($member_id!="" && $id!=""){
			$member=$this->member_model->get_row_byid($member_id);			
			$this->load->model('electronic_currency_market_model');
			$data['buyer_id']=$member_id;
			$data['buyer_user']=$member->user;
			$data['buyer_mobile']=$member->mobile;
			$data['btime']=time();
			$data['state']=1;
			$return_result=$this->electronic_currency_market_model->update_data($data,$id);
			if($return_result>0){
				$this->session->set_flashdata('success_show', '购买成功');
				redirect("electronic_currency_market");
			}else{
				$this->session->set_flashdata('error_show', '购买失败');
				redirect("electronic_currency_market");
			}
		}else{
				$this->session->set_flashdata('error_show', '购买失败');
				redirect("electronic_currency_market");
		}
	}
	public function undo($id){		
		$this->load->model('member_model');
		$member_id=$this->login_lib->member_id();
		if($member_id!="" && $id!=""){			
			$this->load->model('electronic_currency_market_model');
			$electronic_currency_market=$this->electronic_currency_market_model->get_row_byid($id);
			if($electronic_currency_market->member_id==$member_id){						
					$data['buyer_id']=0;
					$data['buyer_user']="";
					$data['buyer_mobile']="";
					$data['btime']=0;
					$data['state']=0;
					$return_result=$this->electronic_currency_market_model->update_data($data,$id);
					if($return_result>0){		
					    $this->session->set_flashdata('success_show', '撤消成功');
						redirect("electronic_currency_market");
					}else{
					    $this->session->set_flashdata('error_show', '撤消失败');
						redirect("electronic_currency_market");
					}
			}else{
				$this->session->set_flashdata('error_show', '撤消失败');
				redirect("electronic_currency_market");
			}
		}else{
			$this->session->set_flashdata('error_show', '撤消失败');
			redirect("electronic_currency_market");
		}
	}

	public function cancel($id){		
		$this->load->model('member_model');
		$member_id=$this->login_lib->member_id();
		if($member_id!="" && $id!=""){			
			$this->load->model('electronic_currency_market_model');
			$electronic_currency_market=$this->electronic_currency_market_model->get_row_byid($id);
			if($electronic_currency_market->member_id==$member_id){
				$return_result=$this->member_model->add_electronic($electronic_currency_market->number,$member_id);//+$electronic_currency_market->poundage	
				if($return_result>0){				
					$return_result=$this->electronic_currency_market_model->delete_byid($id);
						if($return_result){
					       $this->session->set_flashdata('success_show', '取消成功');
							redirect("electronic_currency_market");
						}else{							
					       $this->session->set_flashdata('error_show', '取消失败');
							redirect("electronic_currency_market");
						}
				}else{
					$this->session->set_flashdata('error_show', '取消失败');
					redirect("electronic_currency_market");
				}
			}else{
				$this->session->set_flashdata('error_show', '取消失败');
				redirect("electronic_currency_market");
			}
		}else{
			$this->session->set_flashdata('error_show', '取消失败');
			redirect("electronic_currency_market");
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
				$return_result=$this->member_model->add_electronic($electronic_currency_market->number-$electronic_currency_market->poundage,$electronic_currency_market->buyer_id);
				if($return_result>0){
					$this->load->model('electronic_model');
					$electronic_data['member_id']=$electronic_currency_market->member_id;		
					$electronic_data['user']=$electronic_currency_market->user;						
					$electronic_data['to_member_id']=$electronic_currency_market->buyer_id;					
					$electronic_data['to_user']=$electronic_currency_market->buyer_user;				
					//$electronic_data['to_name']=$electronic_currency_market->name;				
					$electronic_data['type']="sell_electronic";
					$electronic_data['electronic_currency']="-".$electronic_currency_market->number;		
					$electronic_data['to_electronic_currency']=$electronic_currency_market->number-$electronic_currency_market->poundage;	
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
					$electronic_data2['electronic_currency']=$electronic_currency_market->number-$electronic_currency_market->poundage;			
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

/* End of file electronic_currency_market.php */
/* Location: ./application/controllers/electronic_currency_market.php */