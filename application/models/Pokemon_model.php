<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pokemon_model extends CI_Model
{
    function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->library('Pokemon_obj', NULL, 'd');
    }

    function buscar(){
        if($this->d->id != null){
            $arcondicion= array('id'=>$this->d->id);

            if($this->d->Estatus != null ){
                $arcondicion['Estatus'] = $this->d->Estatus;
            }

            if($this->Basedatos->Buscar($this->d,$arcondicion)!=false){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    
    }
    
    function insertar(){
       return $this->Basedatos->Ingresar($this->d);
    }

    function Actualiar($arcondicion){
        return $this->Basedatos->Actualizar($this->d,$arcondicion);
    }
    

}
    ?>