<?php
/* 权限模型 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Privilege_model extends CI_Model{
  private $table = "admin";
  //管理员登陆认证
  public function get_admin($info){
      $query = $this->db->where($info)->get($this->table);
      return $query->num_rows() > 0 ? true : false;
  }
}
