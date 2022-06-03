<?php
//funcion para generar le menu
  function tiempo_muerto(){
    $ci =& get_instance();
    $ci->session->salir=0;
    date_default_timezone_set('America/Mexico_City');
    if($ci->session->tipo!=NULL){
      $ci->session->mov=1;
      $ci->load->library('Sesion_obj',NULL,'Sesion_permisos');
      if(($sesion_bd=$ci->Basedatos->BuscarR($ci->Sesion_permisos,
      array('Id_Sesion'=>$ci->session->Sesion,'Fecha_Cierre'=>NULL )))!=false){
        $sesion_valorada = new $ci->Sesion_permisos();
        $sesion_valorada->set_objectBD($sesion_bd);
        $date = date_create($sesion_valorada->Fecha_Last_Move);
        date_add($date, date_interval_create_from_date_string('55 minutes'));
        if((strtotime(date('Y-m-d H:i:s'))>strtotime($date->format('Y-m-d H:i:s'))) || $ci->session->token!=$sesion_valorada->Token){
          $ci->session->mov=0;
          $ci->session->salir=1;
        }
        $ci->session->mov=0;
      }else{
        $ci->session->mov=0;
        $ci->session->salir=2;
       }
    }else{
      $ci->session->mov=0;
      $ci->session->salir=2;
    }

  }

 ?>
