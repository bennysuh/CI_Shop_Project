<?php
/* 前天首页控制器 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Home_Controller{
	public function __construct(){
		parent::__construct();
		//加载商品分类模型
		$this->load->model('Category_model');
		//加载商品模型
		$this->load->model('Goods_model');
	}
	public function index(){
		//获取分类信息
		$data['cates'] =	$this->Category_model->front_cate();
		//获取好评商品
		$data['best_goods'] = $this->Goods_model->best_goods();
		$this->load->view('index.html',$data);
	}
}
