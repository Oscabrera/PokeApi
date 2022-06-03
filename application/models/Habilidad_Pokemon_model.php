<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Habilidad_Pokemon_model extends CI_Model
{
    function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->library('Habilidad_Pokemon_obj', NULL, 'hp');
    }

    function buscar(){
        if($this->hp->id_Pokemon != null && $this->hp->id_Habilidad != null){
            $arcondicion= array('id_Pokemon'=>$this->hp->id_Pokemon,'id_Habilidad'=>$this->hp->id_Habilidad );
            if($this->Basedatos->Buscar($this->hp,$arcondicion)!=false){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    
    }

    function insertar(){
        return $this->Basedatos->Ingresar($this->hp);
    }

    function Actualiar($arcondicion){
        return $this->Basedatos->Actualizar($this->hp,$arcondicion);
    }

}
    ?>