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
	//获取所有的商品数量
	public function get_all_nums(){
		$query = $this->db->get($this->table);
		return $query->num_rows();
	}
	//根据分页数据获取商品
	public function get_by_page($offset,$limit){
		$query = $this->db->limit($limit,$offset)->get($this->table);
		return $query->result_array();
	}
	//获取搜索商品总数
	public function get_all_search($condition){
		$query = $this->db->where($condition)->get($this->table);
		return $query->num_rows();
	}

	//根据条件搜索商品
	public function get_by_search($condition,$offset,$limit){
		$query = $this->db->where($condition)->limit($limit,$offset)->get($this->table);
		return $query->result_array();
	}

	//根据编号获取商品
	public function get_goods($goods_id){
		$condition['goods_id'] = $goods_id;
		$query = $this->db->where($condition)->get($this->table);
		return $query->row_array();
	}
	//更新商品信息
	public function update_goods($goods_id,$info){
		$condition = array('goods_id'=>$goods_id);
		$this->db->where($condition);
		$this->db->update($this->table,$info);
		return $this->db->affected_rows();
	}

  //获取受到好评商品
	public function best_goods(){
		$condition['is_best'] = 1;
		$query = $this->db->where($condition)->get($this->table);
		return $query->result_array();
	}
	//获取所有的供货商
	public function get_all_sup(){
		$table = "supplier";
		$query = $this->db->get($table);
		return $query->result_array();
	}
	//插入商品相册
	public function add_to_galary($galary){
		$table = "galary";
		return $this->db->insert($table,$galary);
	}
	//更新商品相册
	public function update_to_galary($goods_id,$data_img){
		$table = "galary";
		$condition = array('goods_id'=>$goods_id);
		$this->db->where($condition);
		$this->db->update($table,$data_img);
		return $this->db->affected_rows();
	}
	//查询商品相册
	public function get_goods_galary($goods_id){
		$table = "galary";
		$condition = array('goods_id'=>$goods_id);
		$query = $this->db->where($condition)->get($table);
		return $query->result_array();
	}
}
