<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends Admin_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('Category_model');
		$this->load->library('form_validation');
	}

	public function index(){
		$data['cates'] = $this->Category_model->list_cate();
		$this->load->view('cat_list.html',$data);
	}

	public function add(){
		$data['cates'] = $this->Category_model->list_cate();
		$this->load->view('cat_add.html',$data);
	}

	public function insert(){
		$this->form_validation->set_rules('cat_name','分类名称','trim|required');
		if($this->form_validation->run() == false){
			$data['message'] = validation_errors();
			$data['wait'] = 3;
			$data['url'] = site_url('Admin/Category/add');
			$this->load->view('message.html',$data);
		}else{
			$data['cat_name'] = $this->input->post('cat_name',true);
			$data['parent_id'] = $this->input->post('parent_id');
			$data['unit'] = $this->input->post('unit',true);
			$data['sort_order'] = $this->input->post('sort_order',true);
			$data['cat_desc'] = $this->input->post('cat_desc',true);
			$data['is_show'] = $this->input->post('is_show');
			if($this->Category_model->add_category($data)){
				$data['message'] = "插入商品类别成功!";
				$data['wait'] = 3;
				$data['url'] = site_url('Admin/Category/index');
				$this->load->view('message.html',$data);
			}else{
				$data['message'] = "插入商品类别失败!";
				$data['wait'] = 3;
				$data['url'] = site_url('Admin/Category/add');
				$this->load->view('message.html',$data);
			}
		}
	}

	public function edit($cat_id){
		$data['current_cate'] = $this->Category_model->get_cate($cat_id);
		$data['cates'] = $this->Category_model->list_cate();
		$this->load->view('cat_edit.html',$data);
	}

	public function update(){
		$cat_id = $this->input->post('cat_id');
		$sub_cate = $this->Category_model->list_cate($cat_id);
		$sub_ids = array();
		foreach ($sub_cate as $cate) {
			$sub_ids[] = $cate['cat_id'];
		}
		$parent_id = $this->input->post('parent_id');
		if($parent_id == $cat_id || in_array($parent_id,$sub_ids)){
			$data['message'] = "不能将当前分类放入其下!";
			$data['url'] = site_url('Admin/Category/edit').'/'.$cat_id;
			$data['wait'] = 3;
			$this->load->view('message.html',$data);
		}else{
			$data['cat_name'] = $this->input->post('cat_name',true);
			$data['parent_id'] = $this->input->post('parent_id');
			$data['unit'] = $this->input->post('unit',true);
			$data['sort_order'] = $this->input->post('sort_order',true);
			$data['cat_desc'] = $this->input->post('cat_desc',true);
			$data['is_show'] = $this->input->post('is_show');
			if($this->Category_model->update_cate($data,$cat_id)){
				$data['message'] = "更新商品类别成功!";
				$data['wait'] = 3;
				$data['url'] = site_url('Admin/Category/index');
				$this->load->view('message.html',$data);
			}else{
				$data['message'] = "更新商品类别失败!";
				$data['wait'] = 3;
				$data['url'] = site_url('Admin/Category/edit').'/'.$cat_id;
				$this->load->view('message.html',$data);
			}
		}
	}
}