<?php
/* 商品分类控制器 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends Admin_Controller{

	public function __construct(){
		parent::__construct();
    //加载分类模型
		$this->load->model('Category_model');
    //加载CI的表单验证类
		$this->load->library('form_validation');
	}

  //显示分类信息
	public function index(){
		//获取所有分类信息
		$info = $this->Category_model->list_cate();
		foreach($info as &$value){
			$value['goods_num'] = $this->Category_model->get_goods_num($value['cat_id']);
		}
		$data['cates'] = $info;
    $this->load->view('cat_list.html',$data);
	}
  //显示添加表单
	public function add(){
		//获取所有分类信息
		$data['cates'] = $this->Category_model->list_cate();
    $this->load->view('cat_add.html',$data);
	}
  //执行添加操作
	public function insert(){
    //客户端表单验证
		$this->form_validation->set_rules('cat_name','分类名称','trim|required');
    if($this->form_validation->run() == false){
			$data['message'] = validation_errors();
			$data['wait'] = 3;
			$data['url'] = site_url('admin/Category/add');
			$this->load->view('message.html',$data);
		}else{
			$data['cat_name'] = $this->input->post('cat_name',true);
			$data['parent_id'] = $this->input->post('parent_id');
			$data['unit'] = $this->input->post('unit',true);
			$data['sort_order'] = $this->input->post('sort_order',true);
			$data['cat_desc'] = $this->input->post('cat_desc',true);
			$data['is_show'] = $this->input->post('is_show');
			$data['show_in_nav'] = $this->input->post('show_in_nav');
			$data['cat_recommend'] = !empty($this->input->post('cat_recommend')) ? implode("-",$this->input->post('cat_recommend')) : "";
      //添加分类信息至数据库
			if($this->Category_model->add_category($data)){
				$data['message'] = "插入商品类别成功!";
				$data['wait'] = 3;
				$data['url'] = site_url('admin/Category/index');
				$this->load->view('message.html',$data);
			}else{
				$data['message'] = "插入商品类别失败!";
				$data['wait'] = 3;
				$data['url'] = site_url('admin/Category/add');
				$this->load->view('message.html',$data);
			}
		}
	}
	//显示编辑表单
	public function edit($cat_id){
		//获取当前分类信息
		$data['current_cate'] = $this->Category_model->get_cate($cat_id);
		//获取所有分类信息
		$data['cates'] = $this->Category_model->list_cate();
		$this->load->view('cat_edit.html',$data);
	}
  //执行更新操作
	public function update(){
		//获取隐藏域的分类编号
		$cat_id = $this->input->post('cat_id');
		//获取当前分类的子分类
		$sub_cate = $this->Category_model->list_cate($cat_id);
		$sub_ids = array();
		//获取所有子分类的编号
		foreach ($sub_cate as $cate) {
			$sub_ids[] = $cate['cat_id'];
		}
		$parent_id = $this->input->post('parent_id');
		//判断是否放入自己或子分类中
		if($parent_id == $cat_id || in_array($parent_id,$sub_ids)){
			$data['message'] = "不能将当前分类放入其子分类下!";
			$data['url'] = site_url('admin/Category/edit').'/'.$cat_id;
			$data['wait'] = 3;
			$this->load->view('message.html',$data);
		}else{
			$data['cat_name'] = $this->input->post('cat_name',true);
			$data['parent_id'] = $this->input->post('parent_id');
			$data['unit'] = $this->input->post('unit',true);
			$data['sort_order'] = $this->input->post('sort_order',true);
			$data['cat_desc'] = $this->input->post('cat_desc',true);
			$data['is_show'] = $this->input->post('is_show');
			$data['show_in_nav'] = $this->input->post('show_in_nav');
			$data['cat_recommend'] = !empty($this->input->post('cat_recommend')) ? implode("-",$this->input->post('cat_recommend')) : "";
			//更新分类信息
			if($this->Category_model->update_cate($data,$cat_id)){
				$data['message'] = "更新商品类别成功!";
				$data['wait'] = 3;
				$data['url'] = site_url('admin/Category/index');
				$this->load->view('message.html',$data);
			}else{
				$data['message'] = "更新商品类别失败!";
				$data['wait'] = 3;
				$data['url'] = site_url('admin/Category/edit').'/'.$cat_id;
				$this->load->view('message.html',$data);
			}
		}
	}

	//删除商品分类
	public function delete($cat_id){
		$cnodes = $this->Category_model->list_cate($cat_id);
		//判断商品是否有子分类
		if(!empty($cnodes)){
			$data['message'] = "分类下有子节点，不能删除!";
			$data['wait'] = 3;
			$data['url'] = site_url('admin/Category/index');
			$this->load->view('message.html',$data);
		}else{
			$goods = $this->Category_model->get_goods($cat_id);
			//判断商品分类下是否有商品
			if(!empty($goods)){
				$data['message'] = "分类下有商品，不能删除!";
				$data['wait'] = 3;
				$data['url'] = site_url('admin/Category/index');
				$this->load->view('message.html',$data);
			}else{
				if($this->Category_model->delete_cate($cat_id)){
					$data['message'] = "分类删除成功!";
					$data['wait'] = 3;
					$data['url'] = site_url('admin/Category/index');
					$this->load->view('message.html',$data);
				}else{
					$data['message'] = "分类删除失败!";
					$data['wait'] = 3;
					$data['url'] = site_url('admin/Category/index');
					$this->load->view('message.html',$data);
				}
			}
		}
	}

}
