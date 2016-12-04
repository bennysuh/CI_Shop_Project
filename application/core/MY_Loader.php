<?php
/* 扩展CI加载器，添加开启和关闭皮肤功能 */
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Loader extends CI_Loader{

	protected $_theme = 'default/';
	//开启皮肤功能
	public function switch_themes_on(){
		//重新设定视图文件夹的路径
		$str = str_replace("\\","/",FCPATH.THEMES_DIR.$this->_theme);
		$this->_ci_view_paths = array($str  => TRUE);
	}
	//关闭皮肤功能
	public function switch_themes_off(){

	}
}
