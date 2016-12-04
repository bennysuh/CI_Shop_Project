<?php
/* 商品属性模型 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Attribute_model extends CI_Model{
	private $table = "attribute";

	//添加商品属性
	public function add_attrs($data){
		return $this->db->insert($this->table,$data);
	}

	//查询商品属性
	public function list_attrs(){
		$query = $this->db->get($this->table);
		return $query->result_array();
	}

	//根据编号获取
	public function get_attrs($type_id){
		$condition['type_id'] = $type_id;
		$query = $this->db->where($condition)->get($this->table);
		return $query->result_array();
	}
}
