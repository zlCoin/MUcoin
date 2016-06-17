<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 *
 *
 *
 * @package     chuanqi
 * @subpackage  models
 * @category    models
 * @author      hyw
 * @copyright   copyright (c) 2012
 * @filesource
 */
class Base_model extends CI_Model
{
    protected $_table_name = ''; //Table Name
    protected $_fields = NULL; //Fields to return from table
    protected $_protect_fields = TRUE;
    protected $_id;
    protected $_info;
    protected $error_msg = array();
    //处理信息的语言包
    protected $msg_lang = '';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Delete
     *
     * @access public
     * @param string $name Table Name
     * @param mixed $where Rows to delete
     * @return Query Object
     */
    public function delete($where = null)
    {
        if ($where === null)
        {
            $this->db->where(array($this->_key_name => $this->_id));
        } else
        {
            foreach ($where as $key => $val)
            {
                if (is_array($val))
                {
                    $this->db->where($val);
                } else
                {
                    $this->db->where($val, NULL, false);
                }
            }
        }
        return $this->db->delete($this->_table_name);
    }

    /**
     * 输出错误
     * @param string $open
     * @param string $close
     */
    public function display_errors($open = '', $close = '')
    {
        $str = '';
        foreach ($this->_error_msg as $val)
        {
            $str .= $open . $this->lang->line($val) . $close;
        }
        return $str;
    }

    /**
     * Fetch
     *@access public
     *
     */
    public function fetch($fields = NULL, $where = NULL, $limit = NULL, $back = "result")
    {
        ($fields != NULL) ? $this->db->select($fields) : '';
        ($where != NULL) ? $this->db->where($where) : '';
        ($limit != NULL) ? $this->db->limit($limit['rows'], $limit['offset']) : '';
        $query = $this->db->get($this->_table_name);
        if ($back == "row"){
            return $query->row();
        }else if($back == "count"){
			return $query->num_rows();
		}else if($back == "array"){
			return $query->result_array();
		}else{
            return $query->result();
		}
    }

    /**
     * fetch_count
     * 返回查询所得的总行数
     * @access public
     */
    public function fetch_count()
    {
        return $this->db->count_all_results($this->_table_name);
    }

	/**
     * fetch_sum
     * 返回总和
     * @access public
     */
	public function fetch_sum($field)
    {
        $this->db->select_sum($field);
		$result = $this->db->get($this->_table_name);
		$result = $result->result_array();
		return $result;
    }

    /**
     * fetch_count_all
     * 返回当前数据表的总行数
     * @access public
     */
    public function fetch_count_all()
    {
        return $this->db->count_all($this->_table_name);
    }

    /**
     * Fetch_query
     *@access public
     *
     */
    public function fetch_query($fields = NULL, $where = NULL, $limit = NULL)
    {
        ($fields != NULL) ? $this->db->select($fields) : '';
        ($where != NULL) ? $this->db->where($where) : '';
        ($limit != NULL) ? $this->db->limit($limit['rows'], $limit['offset']) : '';
        return $this->db->get($this->_table_name);
    }

    /**
     * fetch_result
     *
     * @access public
     * @param boole $return_array 是否返回数组，默认FALSE返回的是对像
     */
    public function fetch_result($return_array = FALSE)
    {
        //释放 查询字段
        $this->release(array('_fields'));
        $query = $this->db->get($this->_table_name);
        if ($query->num_rows() > 0)
        {
            if (! $return_array)
            {
                return $query->result();
            } else
            {
                return $query->result_array();
            }
        } else
        {
            return array();
        }
    }

    /**
     * fetch_result
     * 返回数组
     * @access public
     */
    public function fetch_result_array()
    {
        return $this->fetch_result(TRUE);
    }

    /**
     * fetch_row
     * 返回查询结果的一行记录
     * @access public
     * @param int $rows 是否第几行
     * @param boole $return_array 是否返回数组，默认FALSE返回的是对像
     */
    public function fetch_row($rows = '', $return_array = FALSE)
    {
        //释放 查询字段
        $this->release(array('_fields'));
        $query = $this->db->get($this->_table_name);
        if ($query->num_rows() > 0)
        {
            if (! $return_array)
            {
                return $query->row($rows);
            } else
            {
                return $query->row_array($rows);
            }
        }
    }

    /**
     * fetch_row_array
     * 返回数组
     * @param int $rows 是否第几行
     * @access public
     */
    public function fetch_row_array($rows = '')
    {
        return $this->fetch_row($rows, TRUE);
    }

    /**
     * get_info
     * 返回对象
     * @param
     * @access public
     */
    public function get_info($id = NULL, $where = NULL)
    {
        if ($id == NULL)
            $id = $this->_id;
        if ($where != NULL)
        {
            if (is_array($where))
                $this->db->where($where);
            else
                $this->db->where(array($where => $id));
        } else
            $this->db->where(array($this->_key_name => $id));
        $query = $this->db->get($this->_table_name);
        $this->_info = $query->row();
        return $this->_info;
    }

    /*********************end justin add************************************/
    /**
     * Insert
     *
     * @access public
     * @param string $name Table Name
     * @param array $data Data to insert
     * @return Query Object
     */
    public function insert($data)
    {
        $this->db->insert($this->_table_name, $data);
        $this->_id = $this->db->insert_id();
        return $this->_id ? $this->_id : 0;
    }

    public function is_update($info)
    {
        $res = false;
        foreach ($info as $key => $val)
        {
            if (strpos($key, '_mtime') !== false)
            {
                continue;
            }
            if (isset($this->_info->$key))
            {
                $res = ($val == $this->_info->$key) ? false : true;
            } else
            {
                $res = true;
            }
            if ($res)
                break;
        }
        return $res;
    }

    /**
     * 一般通用的名称键对
     * @author kis 2010-10-25
     * @since Version 3.0
     */
    public function name_array()
    {
        if (! $this->_key_name)
        {
            return array();
        }
        $id = $this->_key_name;
        $tmp = str_replace('_id', '', $id);
        $arr = explode('_', $tmp);
        $name = '';
        foreach ($arr as $val)
        {
            $name .= $val['0'];
        }
        return $this->_name_array($id, $name . '_name');
    }

    /**
     * set_args_array
     *
     * @access public
     * @param array $config 参数数组，用下标来获取调用的function
     * $funarray["where"] = array('c_id'=>2);
     * $funarray["join"] = "consumer_integral_log,consumer.c_id = consumer_integral_log.cil_user_id,left";
     * $funarray["group_by"] = "c_id";
     */
    public function set_args_array($config = array())
    {
        $this->load->helper('array');
        foreach ($config as $key => $val)
        {
            $func = 'set_' . $key;
            if (method_exists($this, $func))
            {
                //if (!is_array($val)) $val = array($val);
                $val = array(
                        $key => $val);
                call_user_func_array(array($this, $func), $val);
            }
        }
    }

    /**
     * 输入错误
     * @param string $msg
     */
    public function set_error($msg)
    {
        $this->_error_msg[] = $msg;
    }

    /**
     * set_fields
     *
     * @access public
     * @param string $val 要查询的数据字段名$val = 'title, content, date'
     * @param mixed $protect 为TRUE使用反引号保护你的字段或者表名，FALSE时用于复合查询
     */
    public function set_fields($val, $protect = TRUE)
    {
        $this->_fields = $val ? $val : NULL;
        $this->_protect_fields = $protect;
        ($this->_fields != NULL) ? $this->db->select($this->_fields, $this->_protect_fields) : '';
        return;
    }

    /**
     * fetch_group_by
     *
     * @access public
     * @param array $group_by group by的条件
     */
    public function set_group_by($group_by)
    {
        ($group_by != NULL) ? $this->db->group_by($group_by) : '';
    }

    /**
     * set_id
     * 返回对象
     * @param
     * @access public
     */
    public function set_id($id = '', $fields = NULL)
    {
        if ($fields != NULL)
        {
            if (! is_array($fields))
            {
                $fields = array($fields => $id);
            }
            $this->db->where($fields);
            $this->_info = $this->db->get($this->_table_name)->row();
            $this->_id = $this->_info ? $this->_info->{$this->_key_name} : '';
        } else
        {
            $this->_id = $id ? $id : '';
        }
        return $this->_id;
    }

    /**
     * fetch_order_by
     *
     * @access public
     * @param array $order_by 排序的条件$join="consumer_integral_log,consumer.c_id = consumer_integral_log.cil_user_id,left"
     */
    public function set_join($join)
    {
        if ($join != NULL)
        {
            if (! is_array($join))
                $join = array($join);
            foreach ($join as $key => $val)
            {
                $join_array = explode(',', $val);
                $join_name = $join_array['0'];
                $on_where = isset($join_array['1']) ? $join_array['1'] : '';
                $direction = isset($join_array['2']) ? $join_array['2'] : '';
                $this->db->join($join_name, $on_where, $direction);
            }
        }
    }

    /**
     * set_limit
     *
     * @access public
     * @param array $limit 当$limit为“count”时返回当前的总行数，为$limit ='3,2'时显示3行偏移2行开始limit 2,3
     */
    public function set_limit($limit)
    {
        if ($limit != NULL)
        {
            $limit_array = explode(",", $limit);
            $rows = intval($limit_array['0']);
            $offset = isset($limit_array['1']) ? intval($limit_array['1']) : 0;
            $this->db->limit($rows, $offset);
        }
    }

    /**
     * fetch_order_by
     *
     * @access public
     * @param array $order_by 排序的条件$order_by=array('id,desc')或'id,desc'
     */
    public function set_order_by($order_by)
    {
        if ($order_by != NULL)
        {
            if (! is_array($order_by))
                $order_by = array($order_by);
            foreach ($order_by as $key => $val)
            {
                $order_array = explode(',', $val);
                $title = $order_array['0'];
                $desc = isset($order_array['1']) ? strtoupper($order_array['1']) : 'ASC';
                $this->db->order_by($title, $desc);
            }
        }
    }

    /**
     * set_where
     *
     * @access public
     * @param array $where 要查询的条件$where[] = array('id'=>3)
     */
    public function set_where($where = NULL)
    {
        if ($where != NULL && is_array($where))
        {
            foreach ($where as $key => $val)
            {
                if (is_array($val))
                {
                    $this->db->where($val);
                } else
                {
                    $this->db->where($val, NULL, false);
                }
            }
        }
        return;
    }

    /**
     * Update
     *
     * @access public
     * @param string $name Table Name
     * @param array $values Data to change
     * @param mixed $where Rows to update
     * @return Query Object
     */
    public function update($values = NULL, $where = NULL)
    {
        if ($where != NULL)
        {
            foreach ($where as $key => $val)
            {
                if (is_array($val))
                {
                    $this->db->where($val);
                } else
                {
                    $this->db->where($val, NULL, false);
                }
            }
        } else
            $this->db->where(array($this->_key_name => $this->_id));
        if ($values == NULL)
            $this->db->update($this->_table_name);
        else
            $this->db->update($this->_table_name, $values);
        $rows = $this->db->affected_rows();
        return $rows ? $rows : false;
    }

    /**
     * 返回 名字 键值对,条件不限(继承者附加)
     * @author kis 2010-10-25
     * @since Version 3.0
     * @param int $id 键对应的字段名称
     * @param string $name 值对应的字段名称
     */
    protected function _name_array($id, $name)
    {
        $ret = array();
        $query = $this->fetch_query();
        while ($row = mysql_fetch_object($query->result_id))
        {
            $ret[$row->$id] = $row->$name;
        }
        return $ret;
    }

    /**
     * release
     *
     * @access public
     * @param string $where 释放查询结果
     */
    protected function release($info = array())
    {
        foreach ($info as $val)
        {
            $this->$val != NULL ? $this->$val = NULL : '';
        }
    }

    /**
     * 返回在逻辑层处理好翻译的数据集
     * @author kis 2010-11-17
     * @since Version 3.0;
     * @param string $translate
     * @param array $extend
     */
    protected function translate_result($translate = '', $extend = null)
    {
        if (! $translate)
        {
            return $this->fetch_result();
        }
        $ret = array();
        $query = $this->fetch_query();
        while ($row = mysql_fetch_object($query->result_id))
        {
            $ret[] = $this->translate_val($row, $translate, $extend);
        }
        return $ret;
    }

    /**
     * 判断哪一些数据库字段需要中文转义
     * @author kis 2010-11-17
     * @since Version 3.0;
     * @param mixed $item 当前字段
     * @param string $config 需要转义的字段列表
     * @return boolean true|false
     */
    public function translate_required($item, $config = null)
    {
        if ($config == 'all')
        {
            return true;
        } elseif (strpos($config, ',') === false)
        {
            return $item == $config;
        } else
        {
            $arr = explode(',', $config);
            return in_array($item, $arr);
        }
    }

	public function set_or_like($key,$val , $wildcard = null) {
		$arr = explode(',', $key);
		$where ="";
		foreach($arr as $_val){
			if($where==""){
				if($wildcard=='before')
					$where= $_val." LIKE '%".$val."'";
				else if($wildcard=='after')
					$where= $_val." LIKE '".$val."%'";
				else
					$where= $_val." LIKE '%".$val."%'";
			}else{ 
				if($wildcard=='before')
					$where.=" OR ".$_val." LIKE '%".$val."'";
				else if($wildcard=='after')
					$where.=" OR ".$_val." LIKE '".$val."%'";
				else
					$where.=" OR ".$_val." LIKE '%".$val."%'";
			}
		}
		$where="(".$where.")";
		$this->db->where($where);
	}
	
	
	public function set_or_where($_val,$key) {
		$where ="";
		foreach($key as $val){
			if($where=="")
				$where= $_val." = '".$val."'";
			else 
				$where.=" OR ".$_val." = '".$val."'";
		}
		$where="(".$where.")";
		$this->db->where($where);
	}
	
	public function set_in_where($_val,$key) {
		$where ="";
		if(is_array($_val) and !empty($_val)){
		  	$where= $key." in (".implode(",",$_val).")";	
		 }else if(is_string($_val) and !empty($_val)){
			$where= $key." in (".$val.")";	
		}
		$this->db->where($where);
	}
	


	public function showary($ary){
		echo "<pre>".print_r($ary,true)."</pre>";
		}
}
/* End of file base_model.php */
/* Location: ./system/application/models/base_model.php */
