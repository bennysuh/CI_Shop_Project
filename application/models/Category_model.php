<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model{

	private $table = "category";

	public function list_cate($pid = 0){
		$query = $this->db->get($this->table);
		$cates = $query->result_array();
		return $this->_tree($cates,$pid);
	}

	private function _tree($arr,$pid=0,$level=0){
		static $tree = array();
		foreach($arr as $val){
			if($val['parent_id'] == $pid){
				$val['level'] = $level;
				$tree[] = $val;
				$this->_tree($arr,$val['cat_id'],$level+1);
			}
		}
		return $tree;
	}

	public function add_category($data){
		return $this->db->insert($this->table,$data);
	}

	public function get_cate($cat_id){
		$condition['cat_id'] = $cat_id;
		$query = $this->db->where($condition)->get($this->table);
		return $query->row_array();
	}

	public function update_cate($data,$cat_id){
		$condition['cat_id'] = $cat_id;
		return $this->db->where($condition)->update($this->table,$data);
	}
}