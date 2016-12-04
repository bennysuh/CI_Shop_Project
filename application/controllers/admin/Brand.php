<?php
/* 商品品牌控制器 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Brand extends Admin_Controller{

	public function __construct(){
		parent::__construct();
		//加载表单验证类
		$this->load->library('form_validation');
		//加载品牌模型
		$this->load->model('Brand_model');
		//加载文件上传类
		$this->load->library('upload');
	}
	//显示品牌信息
	public function index(){
		$data['brands'] = $this->Brand_model->list_brand();
		$this->load->view('brand_list.html',$data);
	}
	//显示添加信息
	public function add(){
		$this->load->view('brand_add.html');
	}
  //执行添加动作
	public function insert(){
		//客户端表单验证
		$this->form_validation->set_rules('brand_name','品牌名称','required');
		if($this->form_validation->run() == false){
			$data['message'] = validation_errors();
			$data['url'] = site_url('admin/Brand/add');
			$data['wait'] = 3;
			$this->load->view('message.html',$data);
		}else{
			//执行文件上传操作
			if($this->upload->do_upload('logo')){
				$fileinfo = $this->upload->data();
				//上传成功返回文件信息
				$data['logo'] = $fileinfo['file_name'];
				$data['brand_name'] = $this->input->post('brand_name');
				$data['url'] = $this->input->post('url');
				$data['brand_desc'] = $this->input->post('brand_desc');
				$data['sort_order'] = $this->input->post('sort_order');
				$data['is_show'] = $this->input->post('is_show');
				//添加品牌信息至数据库
				if($this->Brand_model->add_brand($data)){
					$data['message'] = "品牌添加成功!";
					$data['url'] = site_url('admin/Brand/index');
					$data['wait'] = 3;
					$this->load->view('message.html',$data);
				}else{
					$data['message'] = "品牌添加失败!";
					$data['url'] = site_url('admin/Brand/add');
					$data['wait'] = 3;
					$this->load->view('message.html',$data);
				}
			}else{
				//上传失败返回错误信息
				$data['message'] = $this->upload->display_errors();
				$data['url'] = site_url('admin/Brand/add');
				$data['wait'] = 3;
				$this->load->view('message.html',$data);
			}
		}
	}
	//现实编辑表单
	public function edit($brand_id){
		$data['brand'] = $this->Brand_model->get_brand($brand_id);
		$this->load->view('brand_edit.html',$data);
	}
	//更新品牌信息
	public function update(){
		$data['brand_id'] = $this->input->post('brand_id');
		//无文件上传
		if($_FILES['logo']['error'] == 4){
			$data['brand_name'] = $this->input->post('brand_name');
			$data['url'] = $this->input->post('url');
			$data['brand_desc'] = $this->input->post('brand_desc');
			$data['sort_order'] = $this->input->post('sort_order');
			$data['is_show'] = $this->input->post('is_show');
			if($this->Brand_model->update_brand($data)){
				$data['message'] = "品牌更新成功!";
				$data['url'] = site_url('admin/Brand/index');
				$data['wait'] = 3;
				$this->load->view('message.html',$data);
			}else{
				$data['message'] = "品牌更新失败!";
				$data['url'] = site_url('admin/Brand/edit')."/".$data['brand_id'];
				$data['wait'] = 3;
				$this->load->view('message.html',$data);
			}
		}else{
			//有文件上传
			if($this->upload->do_upload('logo')){
				$fileinfo = $this->upload->data();
				//上传成功返回文件信息
				$data['logo'] = $fileinfo['file_name'];
				$data['brand_name'] = $this->input->post('brand_name');
				$data['url'] = $this->input->post('url');
				$data['brand_desc'] = $this->input->post('brand_desc');
				$data['sort_order'] = $this->input->post('sort_order');
				$data['is_show'] = $this->input->post('is_show');
				//添加品牌信息至数据库
				if($this->Brand_model->update_brand($data)){
					$data['message'] = "品牌更新成功!";
					$data['url'] = site_url('admin/Brand/index');
					$data['wait'] = 3;
					$this->load->view('message.html',$data);
				}else{
					$data['message'] = "品牌更新失败!";
					$data['url'] = site_url('admin/Brand/add');
					$data['wait'] = 3;
					$this->load->view('message.html',$data);
				}
			}else{
				//上传失败返回错误信息
				$data['message'] = $this->upload->display_errors();
				$data['url'] = site_url('admin/Brand/add');
				$data['wait'] = 3;
				$this->load->view('message.html',$data);
			}
		}
	}
	//删除品牌记录
	public function delete($brand_id){
			$goods = $this->Brand_model->get_goods($brand_id);
			if(!empty($goods)){
				$data['message'] = "品牌下有商品,不能删除!";
				$data['url'] = site_url('admin/Brand/index');
				$data['wait'] = 3;
				$this->load->view('message.html',$data);
			}else{
				if($this->Brand_model->delete_brand($brand_id)){
					$data['message'] = "品牌删除成功!";
					$data['url'] = site_url('admin/Brand/index');
					$data['wait'] = 3;
					$this->load->view('message.html',$data);
				}else{
					$data['message'] = "品牌删除失败!";
					$data['url'] = site_url('admin/Brand/index');
					$data['wait'] = 3;
					$this->load->view('message.html',$data);
				}
			}
	}
	//搜索品牌记录
	public function search(){
		$brand_name = $this->input->post("brand_name");
		$data['brands'] = $this->Brand_model->search_brand($brand_name);
		$this->load->view("brand_list.html",$data);
	}
}
