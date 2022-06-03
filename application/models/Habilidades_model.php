<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Habilidades_model extends CI_Model
{
    function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->library('Habilidades_obj', NULL, 'h');
    }

    function buscar(){
        if($this->d->Nombre != null){
            $arcondicion= array('Nombre'=>$this->h->Nombre);
            if($this->Basedatos->Buscar($this->h,$arcondicion)!=false){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
       
    }

    function insertar(){
        return $this->Basedatos->Ingresar($this->h);
    }

    function Actualiar($arcondicion){
        return $this->Basedatos->Actualizar($this->h,$arcondicion);
    }

}
    ?>