<?php
/* 分类模型 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model{

	private $table = "category";

  //获取所有的分类记录
	public function list_cate($pid = 0){
		$query = $this->db->get($this->table);
		$cates = $query->result_array();
		return $this->_tree($cates,$pid);
	}
	//将类别进行重组并返回
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

	//添加分类记录
	public function add_category($data){
		return $this->db->insert($this->table,$data);
	}

	//根据id获取分类
	public function get_cate($cat_id){
		$condition['cat_id'] = $cat_id;
		$query = $this->db->where($condition)->get($this->table);
		return $query->row_array();
	}

	//更新分类信息
	public function update_cate($data,$cat_id){
		$condition['cat_id'] = $cat_id;
		return $this->db->where($condition)->update($this->table,$data);
	}

	//删除分类信息
	public function delete_cate($cat_id){
		$condition['cat_id'] = $cat_id;
		return $this->db->where($condition)->delete($this->table);
	}

	//获取分类下的商品
	public function get_goods($cat_id){
		$table = "goods";
		$condition['cat_id'] = $cat_id;
		$query = $this->db->where($condition)->get($table);
		return $query->result_array();
	}
	
	//获取分类下的商品数量
	public function get_goods_num($cat_id){
		$table = "goods";
		$condition['cat_id'] = $cat_id;
		$query = $this->db->where($condition)->get($table);
		return $query->num_rows();
	}


	public function child($arr,$pid = 0){
		$child = array();
		foreach($arr as $k => $v){
			if($v['parent_id'] == $pid){
				$child[] = $v;
			}
		}
		return $child;
	}

	public function cate_list($arr,$pid = 0){
		$child = $this->child($arr,$pid);
		if(empty($child)){
			return null;
		}else{
			foreach($child as $k => $v){
				$current_child = $this->cate_list($arr,$v['cat_id']);
				if($current_child != null){
					$child[$k]['child'] = $current_child;
				}
			}
		}
		return $child;
	}

	public function front_cate(){
		$query = $this->db->get($this->table);
		$cates = $query->result_array();
		return $this->cate_list($cates);
	}
}
