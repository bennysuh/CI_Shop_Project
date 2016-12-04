<?php
/* 商品类型控制器 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Goodtype extends Admin_Controller{

	public function __construct(){
		parent::__construct();
		//加载CI表单验证类和分页类
		$this->load->library(array('form_validation','pagination'));
		//加载类型模型
		$this->load->model('Goodtype_model');
	}

	//显示类型信息
	public function index($offset = ""){
		//配置分页类数据
		$config['base_url'] = site_url('admin/Goodtype/index');
		$config['uri_segment'] = 4;
		$config['total_rows'] = $this->Goodtype_model->count_goodtype();
		$config['per_page'] = 5;
		//配置分页类显示
		$config['first_link'] = '首页';
		$config['last_link'] = '尾页';
		$config['prev_link'] = '上一页';
		$config['next_link'] = '下一页';
		//初始化表单验证类
		$this->pagination->initialize($config);
		$data['links'] = $this->pagination->create_links();
		$limit = $config['per_page'];
		//根据分页查询数据
		$data['goods_type'] = $this->Goodtype_model->list_goodtype($limit,$offset);
		$this->load->view('goods_type_list.html',$data);
	}
	//显示添加表单
	public function add(){
		$this->load->view('goods_type_add.html');
	}
	//显示编辑表单
	public function edit($type_id){
		$data['goods_type'] = $this->Goodtype_model->get_by_typeid($type_id);
		$this->load->view('goods_type_edit.html',$data);
	}

	public function insert(){
		//客户端表单验证
		$this->form_validation->set_rules('type_name','商品类型名称','required');
		if($this->form_validation->run() == false){
			$data['message'] = validation_errors();
			$data['url'] = site_url('admin/Goodtype/add');
			$data['wait'] = 3;
			$this->load->view('message.html',$data);
		}else{
			$data['type_name'] = $this->input->post('type_name',true);
			//添加类型数据至数据库
			if($this->Goodtype_model->add_goodtype($data)){
				$data['message'] = "类型添加成功!";
				$data['url'] = site_url('admin/Goodtype/index');
				$data['wait'] = 3;
				$this->load->view('message.html',$data);
			}else{
				$data['message'] = "类型添加失败!";
				$data['url'] = site_url('admin/Goodtype/add');
				$data['wait'] = 3;
				$this->load->view('message.html',$data);
			}
		}
	}
}
