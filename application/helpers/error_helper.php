<?php

function mensaje($tipo = 'nulo', $mensaje = ''){
    $ci =& get_instance();
    $mensajes = array();

    array_push($mensajes,array(
        'tipo'=>$tipo,
        'mensaje'=>$mensaje,
    ));
    $ci->session->mensajes=$mensajes;
}

function imprimir_error(){
    $ci =& get_instance();
    $mensajes = $ci->session->mensajes;
    $return = '';
    if($mensajes!=null){
        foreach($mensajes as $mensaje){
            $tipo = $mensaje['tipo'];
            $texto = $mensaje['mensaje'];
            $texto = $mensaje['mensaje'];
            switch($mensaje['tipo']){
                case 'error': $title ='Error'; $tipo ='error'; $color = "red"; break;
                case 'exito': $title ='Éxito'; $tipo ='success'; $color = "green"; break;
                case 'advertencia': $title ='Advertencia'; $tipo ='warning'; $color = "orange"; break;
                default: $title ='Información'; $tipo ='info'; $color = "blue"; break;
            }
            $return .= '<script>toastr.'.$tipo.'("'.$texto.'","'.$title.'")</script>';
        }
    }
    $ci->session->unset_userdata('mensajes');
    return $return;
}


?>
