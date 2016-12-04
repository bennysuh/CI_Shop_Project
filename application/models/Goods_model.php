<?php
/* 商品模型 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Goods_model extends CI_Model{
	public $table = "goods";

	public function __construct(){
		parent::__construct();
	}
	//添加商品返回编号
	public function add_goods($data){
		$query = $this->db->insert($this->table,$data);
		return $query ? $this->db->insert_id() : false;
	}
	//根据编号获取商品
	public function get_goods($goods_id){
		$condition['goods_id'] = $goods_id;
		$query = $this->db->where($condition)->get($this->table);
		return $query->row_array();
	}
  //获取受到好评商品
	public function best_goods(){
		$condition['is_best'] = 1;
		$query = $this->db->where($condition)->get($this->table);
		return $query->result_array();
	}
}
