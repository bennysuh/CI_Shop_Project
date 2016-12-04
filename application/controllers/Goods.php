<?php
/* 前台商品控制器 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Goods extends Home_Controller{
	public function __construct(){
		parent::__construct();
		//加载商品模型
		$this->load->model('Goods_model');
	}
	//根据商品id获取详细信息
	public function index($goods_id){
		$data['goods'] = $this->Goods_model->get_goods($goods_id);
		$this->load->view('goods.html',$data);
	}
}
