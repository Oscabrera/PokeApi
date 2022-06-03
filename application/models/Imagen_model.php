<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Imagen_model extends CI_Model
{
    function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->library('Imagen_obj', NULL, 'i');
    }

    function buscar(){
        if($this->i->id_Pokemon != null && $this->i->Nombre != null ){
            $arcondicion= array('id_Pokemon'=>$this->i->id_Pokemon, 'Nombre' => $this->i->Nombre );
            if($this->Basedatos->Buscar($this->i,$arcondicion)!=false){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
       
    }

    function insertar(){
        return $this->Basedatos->Ingresar($this->i);
    }

    function Actualiar($arcondicion){
        return $this->Basedatos->Actualizar($this->i,$arcondicion);
    }
    
    

}
    ?>