<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Nonactivated_member extends CI_Controller {
	
	
	function __construct(){
        parent::__construct();
    }

	public function index($page=1,$parameter=""){
		$html=$this->admin_init("未激活会员","jquery,login");
		$this->load->model('member_model');
		$search['keyword']=$this->input->post('keyword');
		$search['state']=0;
		$html['keyword']=$search['keyword'];
		$total_rows = $this->member_model->query_data_count($search);
		$html['pagination'] =html_pagination($page,$total_rows,$parameter);		
		$limit =html_limit($page);
		$html['maxnum']=html_num($total_rows);
		$html['total_rows']=$total_rows;
		$html['list']=$this->member_model->query_data($search,$limit);
		//echo $this->db->last_query();
		$this->load->view('/admin/nonactivated_member_list',$html);
	}

	public function show($id=null) {
		$html=$this->admin_init("查看用户","jquery,validate,date");
		$this->load->model('member_model');
		$html['row']=$this->member_model->get_row_byid($id);
		$this->load->view('/admin/member_show',$html);
	}

	public function unlocking($id)
	{
		$this->load->model('member_model');
		if($id!=""){
			$data['lock']=0;
			$return_result=$this->member_model->update_data($data,$id);
			if($return_result>0){
				redirect("admin/nonactivated_member");
			}else{
				redirect("admin/nonactivated_member");
			}
		}else{
			redirect("admin/nonactivated_member");
		}

	}

	public function del_action($id=null){
		$this->load->model('member_model');
		if($id!=null){
			$return_result = $this->member_model->delete_byid($id);
			if($return_result){
				redirect("/admin/nonactivated_member");
			}else{
				die("未激活会员删除失败!");
			}
		}else{
			die("未激活会员删除没有指定ID!");
		}
	}



	
	// 激活会员页面
	public function activation($id = null){
		$html = $this->admin_init("激活用户");
		$this->load->model('member_model');
		empty($id) && exit('参数错误');
		$member = $this->member_model->get_row_byid($id);
		if (!$member) exit('该会员不存在');
		$html['member'] = $member;
		$this->load->view('/admin/nonactivated_member_activation',$html);
	}

	// 激活会员提交
	public function activation_submit(){
		header('Content-type: application/json');
		$this->load->model('member_model');
		$this->load->model('free_stock_model');
		$this->load->model('system_set_model');
		$id = $_GET['id'];
		$tc = $_GET['tc'];
		$member = $this->member_model->get_row_byid($id);
		if (!$member) exit(json_encode(array('status'=>0,'info'=>'该会员不存在')));
		$this->parentCount = $this->member_model->my_team_count(array('state'=>1,'parent_id'=>$member->parent_id));
		if($this->parentCount >= 3 && $member->parent_id != '3'){
			exit(json_encode(array('status'=>0,'info'=>'该会员推荐人下已经激活3个会员')));
		}
		$package = fun_switch_package();
		if (!isset($package[$tc])) {
			exit(json_encode(array('status'=>0,'info'=>'套餐不存在！')));
		}
		$system_set = $this->system_set_model->get_row_byid(1);
		$this->db->trans_begin();	// 开始事务
		$data = array();
		$data['member_type'] = 2;// 表示老会员
		$data['tc_price'] = $package[$tc]['numbs'];
		$data['state'] = 1;
		$data['atime'] = time();
		$return_result = $this->member_model->update_data($data, $id);
		if ($return_result) {
			$free_stock_data = array();
			$free_stock_data['member_id'] = $member->member_id;
			$free_stock_data['user'] = $member->user;
			$free_stock_data['clue'] = $member->key;
			$free_stock_data['level'] = $member->level;
			$free_stock_data['no'] = date('Ymdhis').rand(1000,9999);
			$free_stock_data['number'] = 1;	
			$free_stock_data['day_dividend'] = $member->tc_price * $system_set->invest_limit;
			if($this->free_stock_model->add($free_stock_data)){
				$this->db->trans_commit();
				exit(json_encode(array('status'=>1,'info'=>'激活成功')));
			}
		}
		$this->db->trans_rollback();
		exit(json_encode(array('status'=>0,'info'=>'激活失败')));
	}
}

/* End of file nonactivated_member.php */
/* Location: ./application/controllers/admin/nonactivated_member.php */