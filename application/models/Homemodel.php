<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Homemodel extends CI_Model{
  var $columns=array();
  var $table;
  var $where=null;
  function __construct() {
    parent::__construct();
  }

  function set_columns($columns){
    $this->columns=$columns;
  }

  function set_table($table){
    $this->table=$table;
  }

  function set_where($condicion){
    $this->where=$condicion;
  }

  function allposts_count(){
      $this->db->select('count(*) As Total' );
      $this->where_declaration();
      $query = $this->db
          ->get($this->table);
      return $query->result()[0]->Total; // $query->num_rows();
  }

  function posts_search($limit,$start,$search,$col,$dir,$col_search){

      $this->condition_building($search,$col_search);

      $select = '';
      foreach ($this->columns as $key => $colum){
          if($key > 0 && $key<(count($this->columns))){
              $select .=', ';
          }
          $select .=' '.$colum;

      }
      $this->db->select($select );

      $this->db
          ->limit($limit,$start)
          ->order_by($col,$dir);

      $query = $this->db->get($this->table);

      if($query->num_rows()>0){

          return $query->result();
      }else{
          return null;
      }
  }

  function posts_search_count($search,$col_search){
      $this->db->select('count(*) As Total' );
      $this->condition_building($search,$col_search);
      $query = $this->db->get($this->table);
      return $query->result()[0]->Total; // $query->num_rows();
  }

  function condition_building($search,$col_search){
      $array_search=explode(' ',$search);

      $this->where_declaration();

      $this->db->group_start();
      foreach ($this->columns as $key => $value) {
          $this->db->group_start();
          $this->db->like($value,$col_search[$key]);
          $this->db->or_where($value.' is NULL');
          $this->db->group_end();
      }
      $this->db->group_end();

      foreach ($array_search as $keyS => $valueS) {
          $this->db->group_start();
          foreach ($this->columns as $key => $value) {
              if($key==0){
                  $this->db->like($value,$valueS);
              }else{
                  $this->db->or_like($value,$valueS);
              }
          }
          $this->db->group_end();
      }
  }

  function where_declaration(){
      if($this->where!=null){
          $this->db->group_start();
          $this->db->where($this->where);
          $this->db->group_end();
      }
  }

}
