<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Acceso extends CI_Controller {
  var $menu;
    function __construct(){
        parent::__construct();
        $this->load->helper('error');
        $this->load->helper('apoyos');
        $this->load->helper('curl');
        date_default_timezone_set('America/Mexico_City');
    }

// funcion encontrada en logica login realiza todo el procedimeinto del login
  public function index(){
      //$this->Basedatos->Change_VW();
    $this->load->helper('Logica/login');
    l_login();
    //fin logica login

      $datos['accion']='login';
      $this->load->view('manager/head');
      $this->load->view('login/login');
      $this->load->view('manager/footer');
      $this->load->view('login/captcha',$datos);
      $this->load->view('manager/findoc');
  }

//funcion llamada al cerrar sesion
  public function salir(){
    $this->load->library('Sesion_obj',NULL,'SesionB');
    $this->load->library('Usuario_obj',NULL,'Usuario');
    $this->load->helper('Logica/login');
    if(($sesionlocal=$this->Basedatos->Buscar($this->SesionB,array('Id_Usuario'=>$this->session->usu,'Fecha_Cierre'=>NULL )))!=false){
      $this->SesionB->set_objectBD($sesionlocal);
      l_cierresesion($this->SesionB->Id_Sesion);//cierra sesion
    }
    $salir = $this->session->salir;
    $this->session->sess_destroy();
    if($salir==1)
        mensaje('error','Cierre de sesión por tiempo de inactividad prolongado');
    if($salir == 2)
      mensaje('error','Sesión no iniciada');

    redirect(base_url().'acceso');
  }

//funcion con los pasos para la recuperacion de contraseña
  public function recuperar(){
    if($this->input->post()){
        /*$recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
        $recaptcha_secret = '6LdokbAaAAAAACmhERHhkSu2PvZVUAZhEyymhgJB';
        $recaptcha_response = $this->input->post('recaptcha_response');
        $recaptcha = curlGet($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);*/
        // Take action based on the score returned:
        //$recaptcha->score >= 0.6
       if (true ) {
            if($this->input->post('correo')!= null && $this->input->post('correo') !=''){
                $this->load->helper('Logica/login');
                //enviar token de recuperacion
                l_tokenrecuperar();
            }
            mensaje('info','Se enviaron las instrucciones a su correo electrónico para realizar el cambio de contraseña.');

        }
        else{
            mensaje('error','Su conexión es un poco insegura trate de nuevo');
        }

    }

    $datos['accion']='recuperar';
      $this->load->view('manager/head');
      $this->load->view('login/recuperar');
      $this->load->view('manager/footer');
      $this->load->view('login/captcha',$datos);
      $this->load->view('login/igualar_correo');
      $this->load->view('manager/findoc');

  }

//funcion para cambiar contraseña es necesario el token de url y el token de verificacion
  public function restablecer(){
    $data = array();

    if($this->input->post()){
        $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
        $recaptcha_secret = '6LdokbAaAAAAACmhERHhkSu2PvZVUAZhEyymhgJB';
        $recaptcha_response = $this->input->post('recaptcha_response');
        $recaptcha = curlGet($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);

        /*if ($recaptcha->score >= 0.6) { */
            $this->load->helper('Logica/login');
            l_cambiarpass();
            redirect(base_url().'acceso');
        /*}
        else{
            mensaje('error','Su conexión es un poco insegura trate de nuevo');
        }*/

    }else{
      if($this->input->get('token')){
        $data['token'] = $this->input->get('token');
      }else{
          redirect(base_url().'acceso');
      }
    }

    //carga las vistas
      $datos['accion']='restablecer';
      $this->load->view('manager/head');
      $this->load->view('login/cambiaspassword',$data);
      $this->load->view('manager/footer');
      $this->load->view('login/captcha',$datos);
      $this->load->view('login/igualar_pass');
      $this->load->view('manager/findoc');
  }

  /*
  function maeilmuestra(){
    $this->load->library('Token_obj',NULL,'Token');
    $data['token']=$this->Token;
    $this->load->view('login/vistaCorreo',$data);
  }
  */
}
