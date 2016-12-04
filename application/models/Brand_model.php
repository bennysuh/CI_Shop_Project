<?php
/* 品牌模型 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Brand_model extends CI_Model{

	private $table = "brand";

	//添加品牌
	public function add_brand($data){
		return $this->db->insert($this->table,$data);
	}
  //查询品牌
	public function list_brand(){
		$query = $this->db->get($this->table);
		return $query->result_array();
	}
	//获取具体品牌
	public function get_brand($brand_id){
		$condition['brand_id'] = $brand_id;
		$query = $this->db->where($condition)->get($this->table);
		return $query->row_array();
	}
	//搜索相应品牌
	public function search_brand($brand_name){
		$condition['brand_name'] = $brand_name;
		$query = $this->db->like($condition)->get($this->table);
		return $query->result_array();
	}

	//更新品牌信息
	public function update_brand($data){
		$condition['brand_id'] = $data['brand_id'];
		return $this->db->where($condition)->update($this->table,$data);
	}

	public function delete_brand($brand_id){
		$condition['brand_id'] = $brand_id;
		return $this->db->where($condition)->delete($this->table);
	}

	//获取品牌下的商品
	public function get_goods($brand_id){
		$table = "goods";
		$condition['brand_id'] = $brand_id;
		$query = $this->db->where($condition)->get($table);
		return $query->result_array();
	}
}
