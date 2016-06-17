<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 * @package     jike
 * @author      hyw
 * @copyright   hyw copyright (c) 2014
 * @filesource
 */
class Dj_free_model extends Base_model {
    protected $_table_name = 'dj_price_list';
    protected $_key_id = 'id';
	public function get_sums_dj_price($memberid){
		$where['member_id']=$memberid;
		return $this->fetch(NULL, $where,NULL,'row');
 	}


   public function get_row_byid($member_id) {
		$where['member_id'] = $member_id;
		return $this->fetch(NULL, $where,NULL,'row');
	}

	public function add_dj_list($data){
		$data['ctime']=time();
		return $this->insert ($data);
 	}
	public function update_dj_list($dj_price,$member_id) {
		$data['ctime']=time();
		$this->db->set('price', $dj_price, FALSE);
		$where[]=array('member_id'=>$member_id);
		return $this->update($data, $where);
	}
}