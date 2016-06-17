<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class My_team extends CI_Controller {

	function __construct(){
		parent::__construct();
		fun_check_member_state();	// 限制激活操作
		fun_check_password2();
	}
	
	public function index($page=1,$parameter=""){
		$html=$this->init("直属团队","jquery,login");
		$this->load->model('member_model');
		$memberId = $this->login_lib->member_id();
		$search['recommend_id'] = $memberId;
		$total_rows = $this->member_model->my_team_count($search);
		$html['pagination'] = html_pagination($page,$total_rows,$parameter);
		$limit = html_limit($page);
		$html['list'] = $this->member_model->my_team($search,$limit);
		$html['nodeList'] = $this->member_model->my_team(array('parent_id'=>$memberId));
		$this->load->view('/my_team_list',$html);
	}

	public function activation($member_id=null) {
		$this->load->model('member_model');
		$this->load->model('system_set_model');
		$this->load->model('free_stock_model');
		$this->load->model('baodan_log_model');
		$id = $this->login_lib->member_id();
		$this->parentCount = $this->member_model->my_team_count(array('state'=>1,'parent_id'=>$id));
		if($this->parentCount >= 3){
			$this->session->set_flashdata('error_show', '最多激活3个账号！');
			redirect("/My_team/index");
		}
		$this->db->trans_begin();	// 开始事务
		$member = $this->member_model->get_row_byid($id);	// 激活人的会员信息
		$memberSearch = array();
		$memberSearch['member_id'] = intval($member_id);
		$memberSearch['parent_id'] = $member->member_id;
		$memberSearch['state'] = 0;
		$memberSearch['grade'] = 0;
		$member2 = $this->member_model->get_activation_member_all($memberSearch); // 获取被激活会员信息
		if (!$member2) {
			$this->session->set_flashdata('error_show', '操作异常，请联系管理员！');
			redirect("My_team");
		}
		$system_set = $this->system_set_model->get_row_byid(1);	// 系统设置


		if($member->wallet_currency >= $member2->tc_price){
			// 扣除激活人积分记录
			$baodan = array();
			$baodan['member_id'] = $member->member_id;
			$baodan['type'] = 'cash_to_baodan';
			$baodan['details_type'] = '0';
			$baodan['currency'] = $member2->tc_price;
			$baodan['remarks'] = '激活下线扣除积分：'.$member2->tc_price.'-套餐：'.$member2->tc_price;
			$BaodanAdd = $this->baodan_log_model->add($baodan);
			if (!$BaodanAdd) {
				$this->db->trans_rollback();
				$this->session->set_flashdata('error_show', '增加报单记录失败');
				redirect("My_team");
			}
			// 扣除积分
			$return_result = $this->member_model->minus_wallet($member2->tc_price, $id, 1);
			if($return_result > 0){
				$data['dj_price'] = $member2->tc_price;
				$data['state'] = 1;
				$data['member_type'] = 1;
				$data['atime'] = time();
				$return_result = $this->member_model->update_data($data, $member2->member_id);
				if($return_result > 0){
					// 每天静态收益记录 根据此处每周处理
					$free_stock_data['member_id'] = $member2->member_id;
					$free_stock_data['parent_id_count'] = $this->member_model->check_user_byparent_id_count($member2->member_id);
					$free_stock_data['user'] = $member2->user;
					$free_stock_data['clue'] = $member2->key;
					$free_stock_data['level'] = $member2->level;
					$free_stock_data['no'] = date('Ymdhis').rand(1000,9999);
					$free_stock_data['number'] = 1;	
					$free_stock_data['day_dividend'] = $member2->tc_price * $system_set->invest_limit;
					if(!$this->free_stock_model->add($free_stock_data)){
						$this->db->trans_rollback();
						$this->session->set_flashdata('error_show', '静态增加异常！');
						redirect("My_team");
					}
					// 推荐奖：推荐人拿
					if ($member2->recommend_id == $member2->parent_id) {
						$RecommendMember = $member;
					}else{
						$RecommendMember = $this->member_model->get_row_byid($member2->recommend_id);
					}
					if (!$this->member_model->RecommendedAward($member2, $RecommendMember, $system_set)) {
						$this->db->trans_rollback();
						$this->session->set_flashdata('error_show', '推荐奖增加异常！');
						redirect("My_team");
					}
					// 管理奖
					$manageMember = $this->member_model->ParentManageMember($member, $member2->key_comma);	// 获取管理奖会员数据
					if ($manageMember) {
						if (!$this->member_model->recursion_gl($manageMember, $member2)) {
							$this->db->trans_rollback();
							$this->session->set_flashdata('error_show', '管理奖增加异常！');
							redirect("My_team");
						}
					}
 					// 平级奖
 					$ParentMember = $this->member_model->get_row_byid($member->parent_id);
					$layered = fun_switch_package();
					foreach ($layered as $key => $value) {
						if ($value['numbs'] == $member2->tc_price) {
							$layer = $value['layer'];
						}
					}
					if(!$this->member_model->recursion($member, $ParentMember, $layer, $member2)){
						$this->db->trans_rollback();
						$this->session->set_flashdata('error_show', '平级奖增加异常！');
						redirect("My_team");
					}
					$this->db->trans_commit();
					$this->session->set_flashdata('success_show', '激活成功');
					redirect("My_team");
				}else{
					$this->db->trans_rollback();
					$this->session->set_flashdata('error_show', '激活失败');
					redirect("My_team");
				}
			}else{
				$this->db->trans_rollback();
				$this->session->set_flashdata('error_show', '扣除积分失败！');
				redirect("My_team");
			}
		}
		$this->db->trans_rollback();
		$this->session->set_flashdata('error_show', '排单积分不足,激活失败');
		redirect("My_team");
	}
}
/* End of file my_team.php */
/* Location: ./application/controllers/my_team.php */