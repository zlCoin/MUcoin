<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Activation_code extends CI_Controller {
	
	
	function __construct()
    {
        parent::__construct();
    }
	public function index($page=1,$parameter="")
	{
		$html=$this->admin_init("充值卡密码","jquery,login");
		$this->load->model('activation_code_model');
		$search['keyword']=$this->input->post('keyword');
		$html['keyword']=$search['keyword'];
		$total_rows = $this->activation_code_model->query_data_count($search);
		$html['pagination'] =html_pagination($page,$total_rows,$parameter);		
		$limit =html_limit($page);
		$html['maxnum']=html_num($total_rows);
		$html['list']=$this->activation_code_model->query_data($search,$limit);
		$html['activation_code_state']=fun_activation_code_state();
		$this->load->view('/admin/activation_code_list',$html);
	}
	public function  invalid($id){
			$this->load->model('activation_code_model');
			$return_result=$this->activation_code_model->update_invalid($id);	
			if($return_result>0){				
				redirect("admin/activation_code");
			}else{		
				redirect("admin/activation_code");
			}
	}
	public function add() {
		$html=$this->admin_init("充值卡密码新增","jquery,login,validate");		
		$this->load->view('/admin/activation_code_add',$html);
	}
	public function add_submit(){
		$this->load->model('activation_code_model');
		$data['user']=$this->input->post('user');
		$data['number']=$this->input->post('number');
		$data['batch_no']="No".date("Ymdhis")."_".$data['number'];
		if($data['user']!="" && $data['number']!=""){
			$activation_code_data=array();
			$i = 1;
			 while ($i <= $data['number']) {
				$code=$this->sn_maker();
				$count=$this->activation_code_model->check_code_count($code);
				if($count==0){
					$activation_code_data[$i]['code']=$code;
					$activation_code_data[$i]['user']=$data['user'];
					$activation_code_data[$i]['batch_no']=$data['batch_no'];
					$activation_code_data[$i]['state']=0;
					$activation_code_data[$i]['btime']=time();
					$activation_code_data[$i]['ctime']=time();
					$i++;
				}
			 }
			$return_result=$this->activation_code_model->add_batch($activation_code_data);
			redirect("admin/activation_code");
		}else{
			redirect_error("充值卡新增失败!","/admin/activation_code");
		}	
	}

	 function sn_maker($len=10,$format='ALL'){
			$is_abc = $is_numer = 0;
			$password = $tmp ='';  
			switch($format){
				case 'ALL':
					$chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
				break;
				case 'CHAR':
					$chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
				break;
				case 'NUMBER':
					$chars='0123456789';
				break;
				default :
					$chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
				break;
			} 
			mt_srand((double)microtime()*1000000*getmypid());
			while(strlen($password)<$len){
				$tmp =substr($chars,(mt_rand()%strlen($chars)),1);
				if(($is_numer <> 1 && is_numeric($tmp) && $tmp > 0 )|| $format == 'CHAR'){
					$is_numer = 1;
				}
				if(($is_abc <> 1 && preg_match('/[a-zA-Z]/',$tmp)) || $format == 'NUMBER'){
					$is_abc = 1;
				}
				$password.= $tmp;
			}
			return strtoupper($password);
	}

}

/* End of file activation_code.php */
/* Location: ./application/controllers/admin/activation_code.php */