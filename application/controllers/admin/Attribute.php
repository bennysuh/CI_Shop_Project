<?php
/* 商品属性控制器 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Attribute extends Admin_Controller{

	public function __construct(){
		parent::__construct();
		//加载商品类型控制器
		$this->load->model('Goodtype_model');
		//加载商品属性控制器
		$this->load->model('Attribute_model');
	}

	//显示商品属性信息
	public function index(){
		$data['attrs'] = $this->Attribute_model->list_attrs();
		$this->load->view('attribute_list.html',$data);
	}

  //显示添加属性表单
	public function add(){
		$data['good_types'] = $this->Goodtype_model->get_alltype();
		$this->load->view('attribute_add.html',$data);
	}

	//执行添加属性操作
	public function insert(){
		//封装属性数据
		$data['attr_name'] = $this->input->post('attr_name');
		$data['type_id'] = $this->input->post('type_id');
		$data['attr_type'] = $this->input->post('attr_type');
		$data['attr_input_type'] = $this->input->post('attr_input_type');
		$data['attr_value'] = $this->input->post('attr_value');
		//添加属性数据至数据库
		if($this->Attribute_model->add_attrs($data)){
			$data['message'] = "添加属性成功!";
			$data['wait'] = 3;
			$data['url'] = site_url('admin/Attribute/index');
			$this->load->view('message.html',$data);
		}else{
			$data['message'] = "添加属性失败!";
			$data['wait'] = 3;
			$data['url'] = site_url('admin/Attribute/add');
			$this->load->view('message.html',$data);
		}
	}
	//显示编辑属性表单
	public function edit(){
		$this->load->view('attribute_edit.html');
	}
}
