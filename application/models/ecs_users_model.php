<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *
 *
 * @package     jike
 * @author      hyw
 * @copyright   hyw copyright (c) 2014
 * @filesource
 */
class Ecs_users_model extends Base_model {
    protected $_table_name = 'ecs_users';
    protected $_key_id = 'users_id';
  	function get_user_count($user) {
		$sql = "SELECT * FROM ".$this->_table_name." WHERE user_name='".$user."'";
		$query = $this->db->query($sql);
		 return $query->num_rows();
	}
	  function user_money($shopping_currency,$user) {
 
 			$sql = "UPDATE ".$this->_table_name." SET exuser_points=exuser_points+".$shopping_currency." WHERE user_name='".$user."'";
			$this->db->query($sql);
		}
	function update_data($values,$where) {
		foreach ($values as $key => $val)
		{
			$valstr[] = $key . ' = ' . $val;
		}
		$sql = "UPDATE ".$this->_table_name." SET ".implode(', ', $valstr);

		$sql .= ($where != '' AND count($where) >=1) ? " WHERE ".implode(" ", $where) : '';

		$this->db->query($sql);
	}
	function add($user,$pwd,$tel,$email,$is_fenxiao) {

		$sql="insert into ecs_users (user_name,password,mobile_phone,email,is_fenxiao,reg_time,question,answer,sex,birthday,user_money,frozen_money,pay_points,rank_points,address_id,last_login,last_time,last_ip,visit_count,user_rank,is_special,salt,parent_id,flag,alias,msn,qq,office_phone,home_phone,is_validated,credit_line,aite_id,surplus_password,validated,real_name,card,face_card,back_card,country,province,city,district,address,status,mediaUID,mediaID,froms,headimg) values ('".trim(strtoupper($user))."','".$pwd."','".$tel."','".$email."',".$is_fenxiao.",'".time()."',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,0)";
		$this->db->query($sql);
	}

	function get_data(){
		$sql = "select * from q_member m left join ecs_users u on m.user = u.user_name where u.user_name is null";
		$query = $this->db->query($sql);
		 return $query->result();
	}

}