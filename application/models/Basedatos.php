<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Basedatos extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->load->database();
    }

    //Método de inserción de un objeto en la base de datos
    //  usa los metodos de get_table y get_all, que regresan la tabla de inserción y el array data.
    function Ingresar($objeto){
        $this->db->reset_query();
        $query=$this->db->insert($objeto->get_table(),$objeto->get_all());
        if($query) return $this->db->insert_id();
        else return 0;
    }

    //Método para obtener de base de datos apartir de un objeto.
    // recibe un objeto y un arreglo asociativo con clave a buscar y valor
    function Buscar($objeto,$arcondicion){
        $this->db->reset_query();
      foreach ($arcondicion as $key => $value) {
        if($value != NULL && $value != '' ){
          $this->db->where($key,$this->db->escape_str($value));
        }else{
          $this->db->where($key);}
      }
      $query = $this->db->get($objeto->get_table());
        if($query->num_rows()>0) {return $objeto->set_objectBD($query->result()[0]); }
            else return false;
    }

    //Método para obtener de base de datos apartir de un objeto.
    // recibe un objeto y un arreglo asociativo con clave a buscar y valor
    function BuscarR($objeto,$arcondicion){
        $this->db->reset_query();
        foreach ($arcondicion as $key => $value) {
            if($value != NULL && $value != '' ){
                $this->db->where($key,$this->db->escape_str($value));
            }else{
                $this->db->where($key);}
        }
        $query = $this->db->get($objeto->get_table());
        if($query->num_rows()>0) {return $query->result()[0]; }
        else return false;
    }

    //Método que recupera a todos los elementos del tipo objetos
    function Listar($objeto,$arcondicion=null,$orderby=null,$limit=0,$select=false){
        $this->db->reset_query();
        if($select!=false){
            $this->db->select($select);
        }

      if(is_array($arcondicion))
      foreach ($arcondicion as $key => $value) {
        if($value != NULL && $value != '' ){
          $this->db->where($key,$this->db->escape_str($value));
        }else{
          $this->db->where($key);}
      }
      if(is_array($orderby))
      foreach ($orderby as $key => $value) {
          $this->db->order_by($key, $value);
      }
      if($limit>0){
        $this->db->limit($limit);
      }

      $query = $this->db->get($objeto->get_table());

      
        if($query->num_rows()>0) return $query->result();
            else return false;
    }

    // actualizar
    function Actualizar($objeto,$arcondicion){
        $this->db->reset_query();
      if(is_array($arcondicion))
      foreach ($arcondicion as $key => $value) {
        $this->db->where($key,$this->db->escape_str($value));
      }
      $query = $this->db->update($objeto->get_table(),$objeto->get_all());
      if($query) return true;
      else return false;
    }

    function Listar_avanzado($objeto,$seleccion=null,$arcondicion=null,$grupo=null,$orderby=null,$limit=0){
        $this->db->reset_query();
      if(is_array($seleccion))
      foreach ($seleccion as $key => $value) {
        $this->db->select($this->db->escape_str($value));
      }
      if(is_array($arcondicion))
      foreach ($arcondicion as $key => $value) {
        if($value != NULL && $value != '' ){
          $this->db->where($key,$this->db->escape_str($value));
        }else{
          $this->db->where($key);}
      }
      if(is_array($grupo))
        $this->db->group_by($grupo);

      if(is_array($orderby))
      foreach ($orderby as $key => $value) {
          $this->db->order_by($key, $value);
      }
      if($limit>0){
        $this->db->limit($limit);
      }
      $query = $this->db->get($objeto->get_table());

        if($query->num_rows()>0) return $query->result();
            else return false;
    }

    function Buscar_especial($target,$arcondicion){
        $this->db->reset_query();
      foreach ($arcondicion as $key => $value) {
        if($value != NULL && $value != '' ){
          $this->db->where($key,$this->db->escape_str($value));
        }else{
          $this->db->where($key);}
      }
      $query = $this->db->get($target);
        if($query->num_rows()>0) return $query->result()[0];
            else return false;
    }

    function Buscar_especial_Lista($target,$arcondicion,$select,$grupo=null,$orderby=null,$limit=0){
        $this->db->reset_query();
        $this->db->select($select);
        foreach ($arcondicion as $key => $value) {
            if($value != NULL && $value != '' ){
                $this->db->where($key,$this->db->escape_str($value));
            }else{
                $this->db->where($key);}
        }

        if(is_array($grupo))
            $this->db->group_by($grupo);

        if(is_array($orderby))
            foreach ($orderby as $key => $value) {
                $this->db->order_by($key, $value);
            }
        if($limit>0){
            $this->db->limit($limit);
        }

        $query = $this->db->get($target);
        if($query->num_rows()>0) return $query->result_array();
        else return false;
    }

    function Ejecutar_Query($sql){
        $this->db->reset_query();
        $query = $this->db->query($sql);
        if($query->num_rows()>0) return $query->result();
        else return false;
    }


}
?>
