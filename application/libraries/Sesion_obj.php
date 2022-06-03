<?PHP
defined('BASEPATH') OR exit('No direct script access allowed');
include_once (APPPATH.'core/MY_Obj.php'); //sumamanete necesario instancias la clase madre

class Sesion_obj extends MY_Obj{
//construimos el objeto, cuando se instancia con valores,
// estos valores deben ser un array que debe estar asociado a los atributos del objeto,
//  por lo que primero asignamos los atributos.
  function __construct($data=null){
    parent::attr(array(
      'Id_Sesion'=>'id'
      ,'Id_Usuario'=>'usuario'
      ,'Token'=>'token'
      ,'Fecha_Inicio'=>'fecha_ini'
      ,'Fecha_Last_Move'=>'ultimo_mov'
      ,'Fecha_Cierre'=>''
      ,'Ip'=>'ip'
      ,'Id_Dispositivo'=>''
    ));
      parent::__construct($data);
      parent::set_table('Sesion');
      parent::set_relation(array(
        'Id_Usuario'=>'Id_Usuario',
        'Id_Dispositivo'=>'Id_Dispositivo'));
    }
}
?>
