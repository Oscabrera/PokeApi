<?php
//metodo llamado en acceso para el login
function l_login(){
  $ci =& get_instance();
  $ci->load->helper('Funciones/login');
  $ci->load->library('Usuario_obj',NULL,'Usuario');
  $ci->load->library('Tipo_Usuario_obj',NULL,'Tipo_Usuario');

  if($ci->input->post()){
    //obtenemos los elementos del post username y passw
    $user = $ci->input->post('username');
    $password = $ci->input->post('passw');

    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
    $recaptcha_secret = '';
    $recaptcha_response =  $ci->input->post('recaptcha_response');
    // $recaptcha = curlGet($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);

    // Take action based on the score returned:
  // if ($recaptcha->score >= 0.6) {
    //verificar si no esta vacio
    if($user != null && $user != ""){
      //Buscar en la base de datos con el modelo Basedatos, que recibe una libreria como objeto (usuario)
      // bscra recibe el objeto y el arreglo de condiciones
      if(($userlocal=$ci->Basedatos->BuscarR($ci->Usuario,array('Nombre_Acceso'=>$user,'Estado'=>1)))!=false){
        //guardamos el objeto encontrado en la libreria.
        $ci->Usuario->set_objectBD($userlocal);
        //verificamos que el usuario tenga un tipo de usuario activo
        $cond_tipousu=array();
        if($ci->Usuario->Tipo!=1)
          $cond_tipousu=array('Id_Tipo_Usuario'=>$ci->Usuario->Tipo,'Estado'=>1);
        if(($tipouser_bd=$ci->Basedatos->Buscar($ci->Tipo_Usuario,$cond_tipousu))!=false){
          if(l_verificarsesion()){
            //hashear es un helper en login_helper que genera el hash con el algoritmo selecionado
            //echo hashear($password ,$ci->Usuario->Fecha_Cambio_Clave);
            if(hashear($password ,$ci->Usuario->Fecha_Cambio_Clave) ==  $ci->Usuario->Clave_Acceso){
              $fecha = new DateTime();
              l_generatokensesion($fecha->format('Y-m-d H:i:s'));
              l_varsesion();
              $ci->Basedatos->Ingresar($ci->Sesion);
              $ci->session->Sesion=$ci->db->insert_id();
              redirect(base_url('manager/index'));
              //si no encontro usuario mandar mensaje de error mensaje es una funcion de error_helper
            }else{ mensaje('error','Contraseña incorrecta o usuario incorrecto'); }
          }
        }else{ mensaje('error','Contraseña incorrecta, usuario incorrecto o usuario sin acceso'); }
        //de no encontrar el post por razones extrañas enviar error
      }else{ mensaje('error','Contraseña incorrecta, usuario incorrecto o usuario sin acceso'); }
    }
    /*
    }else{
     mensaje('error','Su conexión es un poco insegura trate de nuevo');
   }*/
  }
  else{
    l_cierresesion($ci->session->Sesion);
  }
}

//obtiene el navegador, ip y plataforma para crear el token de sesion
function l_obtenhuella(&$session, &$dispositivo){
  $ci =& get_instance();

  $ci->load->library('user_agent');
  $tipo=1;
  $marca='';
  if ($ci->agent->is_robot()){
    $tipo=3;
    $marca=$ci->agent->robot();
  }
  elseif ($ci->agent->is_mobile()){
    $tipo=2;
    $marca=$ci->agent->mobile();
  }

  $cadena = $ci->agent->agent_string();

  $primersigno = strpos($cadena,'(')+1;
  $segundosigno = strpos($cadena,')');

  $disp=substr($cadena,$primersigno,($segundosigno-$primersigno) );
  $modelo='';
  $disp = explode(';',$disp);
  if(isset($disp[2])){
    $modelo = $disp[2];
  }

  $session->Ip=$ci->input->ip_address();
  if(($dispositivobd=$ci->Basedatos->BuscarR($dispositivo,
  array('Id_Usuario'=>$session->Id_Usuario,'Cadena'=>$cadena)))!=false){
    $dispositivo->set_objectBD($dispositivobd);
    $session->Id_Dispositivo=$dispositivo->Id_Dispositivo;
  }else{
    $dispositivo->Id_Usuario=$session->Id_Usuario;
    $dispositivo->Agente=$ci->agent->browser();
    $dispositivo->Version=$ci->agent->version();
    $dispositivo->Plataforma=$ci->agent->platform();
    $dispositivo->Firma=$marca;
    $dispositivo->Modelo=$modelo;
    $dispositivo->Tipo_Dispositivo=$tipo;
    $dispositivo->Cadena=$ci->agent->agent_string();
    $ci->Basedatos->Ingresar($dispositivo);
    $session->Id_Dispositivo=$ci->db->insert_id();
  }

}

//genera el token hasheado de sesion
function l_generatokensesion($date){
  $ci =& get_instance();
  $ci->load->library('Sesion_obj',null,'Sesion');
  $ci->load->library('Dispositivo_obj',null,'Dispositivo');
  $ci->Sesion->Fecha_Inicio=$date;
  $ci->Sesion->Fecha_Last_Move=$date;
  $ci->Sesion->Id_Usuario=$ci->Usuario->Id_Usuario;
  l_obtenhuella($ci->Sesion,$ci->Dispositivo);
  $text=remplazarparahash($ci->Dispositivo->Cadena);
  $text.=remplazarparahash($ci->Sesion->Ip);
  $ci->Sesion->Token=hashear($text,$ci->Sesion->Fecha_Inicio);

}

//creo las varaibles de sesion necesarias para el sistema
function l_varsesion(){
  $ci =& get_instance();

  $ci->load->library('Tipo_Usuario_obj',NULL,'Tipo_Usuario');
  $ci->Tipo_Usuario->set_objectBD(
    $ci->Basedatos->BuscarR($ci->Tipo_Usuario,
    array('Id_Tipo_Usuario'=>$ci->Usuario->Tipo))
  );
  //construimos el arreglo session con el i de usuario, tipo de persona, el menu,
  // el token de sesión, el id de la persona y el periodo activo
  $ci->session->set_userdata(array('usu'=>$ci->Sesion->Id_Usuario
  ,'tipo'=>$ci->Usuario->Tipo
  ,'tipo_desc'=>$ci->Tipo_Usuario->Nombre
  // ,'imagen_perfil'=>$ci->Usuario->Url_Imagen
  //,'menu'=>$menu
  ,'token'=>$ci->Sesion->Token ));

}

//cierra sesion cuando existe una creada
function l_cierresesion($sesion){
  $ci =& get_instance();
  $ci->load->library('Sesion_obj',null,'SesionFin');
  if($sesion!=NULL){
    if(($sesionlocal=$ci->Basedatos->BuscarR($ci->SesionFin,
    array('Id_Sesion'=>$sesion,'Fecha_Cierre'=>NULL )))!=false){
      $fecha = new DateTime();
      $ci->SesionFin->Fecha_Cierre=$fecha->format('Y-m-d H:i:s');
      $ci->Basedatos->Actualizar($ci->SesionFin,array('Id_Sesion'=>$sesionlocal->Id_Sesion));
    }
    session_unset();
  }
}

//verificar si existe alguna sesión y si el mismo dispositivo continuar de otra forma alertar
function l_verificarsesion(){

  $ci =& get_instance();

  $ci->load->library('Sesion_obj',NULL,'SesionB');
  if(($sesionlocal=$ci->Basedatos->BuscarR($ci->SesionB,
  array('Id_Usuario'=>$ci->Usuario->Id_Usuario,'Fecha_Cierre'=>NULL )))!=false){
    $ci->SesionB->set_objectBD($sesionlocal);
    $date = date_create($ci->SesionB->Fecha_Inicio);
    l_generatokensesion(date_format($date,'Y-m-d H:i:s'));
    if($ci->Sesion->Token===$ci->SesionB->Token){
      l_cierresesion($ci->SesionB->Id_Sesion);//cierra sesion
      return true;
    }else{
      $date = date_create($ci->SesionB->Fecha_Last_Move);
      date_add($date, date_interval_create_from_date_string('7 minutes'));
      if(strtotime(date('Y-m-d H:i:s'))>strtotime($date->format('Y-m-d H:i:s'))){
        l_cierresesion($ci->SesionB->Id_Sesion);
        return true;
      }else{
        mensaje('error','Debe cerrar sesión en otro dispositivo antes de comenzar en otro o espere 7 minutos y vuelva a intentar');
        return false;
      }
    }
  }else{
    l_cierresesion($ci->session->Sesion);
  }
  return true;
}

//genera y envia el token de recuperacion de contraseña
function l_tokenrecuperar(){
  $ci =& get_instance();
  $ci->load->library('Sesion_obj',NULL,'SesionB');
  $ci->load->library('Usuario_obj',NULL,'Usuario');
  $ci->load->library('Token_obj',NULL,'Token');
  $ci->load->helper('Funciones/login');
  $ci->load->helper('funcionphp');

  if(($usuariolocal=$ci->Basedatos->BuscarR($ci->Usuario,array('Correo'=>$ci->input->post('correo'))))!=false){
    $ci->Usuario->set_objectBD($usuariolocal);

    if($ci->Usuario->Correo == $ci->input->post('correo')){
      if(l_verificarsesion()){
        if(($Tokenlocal=$ci->Basedatos->BuscarR($ci->Token,array('Estatus'=>'0','Id_Usuario'=>$ci->Usuario->Id_Usuario)))!=false){
          $tokennew= new $ci->Token();
          $tokennew->Estatus='1';
          $ci->Basedatos->Actualizar($tokennew,array('Id_Token'=>$Tokenlocal->Id_Token));
        }
        $ci->Token->Codigo_validacion = generarclavesistema();
        $ci->Token->Fecha_Peticion=date('Y-m-d H:i:s');
        $ci->Token->Id_Usuario=$ci->Usuario->Id_Usuario;
        $ci->Token->Token = generarToken($ci->input->post('correo'),$ci->Token);
        $data['token']=$ci->Token;
        $ci->Basedatos->Ingresar($ci->Token);
        //$ci->load->view('login/vistaCorreo',$data);
        enviarCorreo($ci->input->post('correo'), $ci->load->view('login/vistaCorreo',$data, true));
      }
    }
  }
}

//obtiene el nuevo password y lo almacena en la base de datos
function l_cambiarpass()
{
  $ci =& get_instance();
  $pass1 = $ci->input->post('contrasenia1');
  $pass2 = $ci->input->post('contrasenia2');
  $codigo = $ci->input->post('codigo');
  $token = $ci->input->post('token');
  $ci->load->library('Token_obj', NULL, 'Token');
  if ($codigo != '' && $pass1 != '' && $pass2 != '' && $token != '') {
    if ($pass1 == $pass2) {
      if (($Tokenlocal = $ci->Basedatos->BuscarR($ci->Token, array('Estatus' => '0', 'Token' => $token))) != false) {
        $tokennew = new $ci->Token();
        $tokennew->set_objectBD($Tokenlocal);
        if ($tokennew->Codigo_validacion == $codigo) {
          if ($tokennew->Token == $token) {
            $ci->load->library('Usuario_obj', NULL, 'Usuario');
            if (($usuariolocal = $ci->Basedatos->Buscar($ci->Usuario, array('Id_Usuario' => $tokennew->Id_Usuario))) != false) {
              $usernew = new $ci->Usuario();
              $ci->load->helper('Funciones/login');
              $usernew->Fecha_Cambio_Clave = date('Y-m-d H:i:s');
              $usernew->Clave_Acceso = hashear($pass1, $usernew->Fecha_Cambio_Clave);
              $ci->Basedatos->Actualizar($usernew, array('Id_Usuario' => $tokennew->Id_Usuario));
              $tokennew2 = new $ci->Token();
              $tokennew2->Estatus = '1';
              $ci->Basedatos->Actualizar($tokennew2, array('Id_Token' => $tokennew->Id_Token));
              mensaje('exito', 'La contraseña fue guardada, debes iniciar sesión con la nueva contraseña.');
            } else {
              mensaje('error', 'La contraseña no se logro cambiar, Disculpa las molestias.');
              //redirect(base_url().'acceso');
              echo 'problema1';
            }
          } else {
            mensaje('error', 'La contraseña no se logro cambiar, Disculpa las molestias.');
            //redirect(base_url().'acceso');
            echo 'problema2';
          }
        }
        else {
          mensaje('error', 'La contraseña no se logro cambiar, Disculpa las molestias.');
        }
      } else {
        mensaje('error', 'La contraseña no se logro cambiar, Disculpa las molestias.');
      }
    } else {
      mensaje('error', 'La contraseña no se logro cambiar, Disculpa las molestias.');
    }
  } else {
    mensaje('error', 'La contraseña no se logro cambiar, Disculpa las molestias.');
  }
}

?>
