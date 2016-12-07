<?php
/* 商品控制器 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Goods extends Admin_Controller{

	//加载相关模型
	public function __construct(){
		parent::__construct();
		$this->load->model('Goods_model');
		$this->load->model('Goodtype_model');
		$this->load->model('Attribute_model');
		$this->load->model('Category_model');
		$this->load->model('Brand_model');
	}
	//显示商品列表
	public function index(){
		$data['cates'] = $this->Category_model->list_cate();
		$data['brands'] = $this->Brand_model->list_brand();
		$data['suppliers'] = $this->Goods_model->get_all_sup();
		$data['goods'] = $this->Goods_model->get_all_goods();
		$this->load->view('goods_list.html',$data);
	}
	//显示添加表单
	public function add(){
		$data['goodtypes'] = $this->Goodtype_model->get_alltype();
		$data['cates'] = $this->Category_model->list_cate();
		$data['brands'] = $this->Brand_model->list_brand();
		$data['suppliers'] = $this->Goods_model->get_all_sup();
		$this->load->view('goods_add.html',$data);
	}
	//执行添加操作
	public function insert(){
		$data['goods_name'] = $this->input->post('goods_name');
		$data['goods_sn'] = "EC".strval(time());
		$data['cat_id'] = $this->input->post('cat_id');
		$data['brand_id'] = $this->input->post('brand_id');
		$data['suppliers_id'] = $this->input->post('suppliers_id');
		$data['market_price'] = $this->input->post('market_price');
		$data['user_price'] = $this->input->post('user_price');
		$data['shop_price'] = $this->input->post('shop_price');
		$data['promote_price'] = $this->input->post('promote_price');
		$data['promote_start_time'] = strtotime($this->input->post('promote_start_time'));
		$data['promote_end_time'] = strtotime($this->input->post('promote_end_time'));
		$data['goods_weight'] = $this->input->post('goods_weight')*$this->input->post('weight_unit');
		$data['goods_number'] = $this->input->post('goods_number');
		$data['warn_number'] = $this->input->post('warn_number');
		$data['goods_desc'] = $this->input->post('goods_desc');
		$data['goods_brief'] = $this->input->post('goods_brief');
		$data['goods_type'] = $this->input->post('goods_type');
		$data['keywords'] = $this->input->post('keywords');
		$data['is_promote'] = isset($_POST['is_promote']) ? $this->input->post('is_promote') : 0;
		$data['is_new'] = isset($_POST['is_new']) ? $this->input->post('is_new') : 0;
		$data['is_hot'] = isset($_POST['is_hot']) ? $this->input->post('is_hot') : 0;
		$data['is_best'] = isset($_POST['is_best']) ? $this->input->post('is_best') : 0;
		$data['is_onsale'] = isset($_POST['is_onsale']) ? $this->input->post('is_onsale') : 0;
		$data['is_alone_sale'] = isset($_POST['is_alone_sale']) ? $this->input->post('is_alone_sale') : 0;
		$data['is_shipping'] = isset($_POST['is_alone_shipping']) ? $this->input->post('is_shipping') : 0;
		$data['add_time'] = time();
		//配置文件上传类
		$config['upload_path'] = './public/uploads/';
		$config['allowed_types'] = 'jpg|gif|png';
		$config['max_size'] = 10000;
		$this->load->library('upload',$config);
		//进行文件上传
		if($this->upload->do_upload('goods_img')){
			$res = $this->upload->data();
			$data['goods_img'] = $res['file_name'];
			//配置图片处理类
			$config_img['source_image'] =  "./public/uploads/".$res['file_name'];
			$config_img['create_thumb'] = true;
			$config_img['maintain_ratio'] = true;
			$config_img['width'] = 160;
			$config_img['height'] = 160;
			$this->load->library('image_lib', $config_img);
			//进行图片处理
			if($this->image_lib->resize()){
				$data['goods_thumb'] = $res['raw_name'].$this->image_lib->thumb_marker.$res['file_ext'];
				//添加商品信息至数据库
				if($goods_id = $this->Goods_model->add_goods($data)){
					$attr_ids = $this->input->post('attr_id_list');
					$attr_values = $this->input->post('attr_value_list');
					//添加商品属性信息至数据库
					foreach($attr_values as $key => $value){
						if(!empty($value)){
							$data2['goods_id'] = $goods_id;
							$data2['attr_id'] = $attr_ids[$key];
							$data2['attr_value'] = $value;
							$this->db->insert('goods_attr',$data2);
						}
					}
					$img_descs = $this->input->post('img_desc');
					$info = $this->upload->multiple('img_url');
					//多文件上传并插入数据库
					if(empty($info['error'])){
						for($i=0;$i<count($info['files']);$i++){
							$data_img['goods_id'] = $goods_id;
							$data_img['img_url'] = $info['files'][$i]['file_name'];
							$data_img['thumb_url'] = "space";
							$data_img['img_desc'] = $img_descs[$i];
							$this->Goods_model->add_to_galary($data_img);
						}
					}
					//添加商品相册信息至数据库
					$data['message'] = "添加商品成功!";
					$data['wait'] = 3;
					$data['url'] = site_url('admin/Goods/index');
					$this->load->view('message.html',$data);
				}else{
					$data['message'] = "添加商品失败!";
					$data['wait'] = 3;
					$data['url'] = site_url('admin/Goods/add');
					$this->load->view('message.html',$data);
				}
			}else{
				$data['message'] = $this->image_lib->display_errors();
				$data['wait'] = 3;
				$data['url'] = site_url('admin/Goods/add');
				$this->load->view('message.html',$data);
			}
		}else{
			$data['message'] = $this->upload->display_errors();
			$data['wait'] = 3;
			$data['url'] = site_url('admin/Goods/add');
			$this->load->view('message.html',$data);
		}
	}
	//显示编辑表单
	public function edit($goods_id){
		$data['goods'] = $this->Goods_model->get_goods($goods_id);
		$data['goodtypes'] = $this->Goodtype_model->get_alltype();
		$data['cates'] = $this->Category_model->list_cate();
		$data['brands'] = $this->Brand_model->list_brand();
		$data['suppliers'] = $this->Goods_model->get_all_sup();
		$this->load->view('goods_edit.html',$data);
	}

	//处理ajax获取分类属性数据的请求
	public function create_attrs_html(){
		$typeid = $this->input->get('type_id');
		$attrs = $this->Attribute_model->get_attrs($typeid);
		$html = '';
		//拼凑页面显示的html
		foreach($attrs as $attr){
			$html .= "<tr>";
			$html .= "<td class='label'>".$attr['attr_name']."</td>";
			$html .= "<td>";
			$html .= "<input type='hidden' name='attr_id_list[]' value='".$attr['attr_id']."'>";
			//根据不同类型的属性分别拼凑
			switch ($attr['attr_input_type']) {
				//文本框
				case 0:
					$html .= "<input name='attr_value_list[]' type='text' size='40'>";
					break;
				//下拉列表
				case 1:
					$arr = explode(PHP_EOL,$attr['attr_value']);
					$html .= "<select name='attr_value_list[]'>";
					$html .= "<option value='-1'>请选择...</option>";
					foreach($arr as $v){
						$html .= "<option value='$v'>$v</option>";
					}
					$html .= "</select>";
					break;
				//文本域
				case 2:
					break;
			}
		}
		echo $html;
	}
}
