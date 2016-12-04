<?php
/* 商品类型模型 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Goodtype_model extends CI_Model{

	private $table = "goods_type";

	//添加商品类型
	public function add_goodtype($data){
		return $this->db->insert($this->table,$data);
	}

	//获取所有类型
	public function get_alltype(){
		$query = $this->db->get($this->table);
		return $query->result_array();
	}

	//分页查询类型
	public function list_goodtype($limit,$offset){
		$query = $this->db->limit($limit,$offset)->get($this->table);
		return $query->result_array();
	}

	//查询类型总数
	public function count_goodtype(){
		return $this->db->count_all($this->table);
	}

	//根据id获取类型
	public function get_by_typeid($type_id){
		$condition = array('type_id'=>$type_id);
		$query = $this->db->where($condition)->get($this->table);
		return $query->row_array();
	}
}
