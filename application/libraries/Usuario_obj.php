<?PHP
defined('BASEPATH') OR exit('No direct script access allowed');
include_once (APPPATH.'core/MY_Obj.php'); //sumamanete necesario instancias la clase madre

class Usuario_obj extends MY_Obj{
//construimos el objeto, cuando se instancia con valores,
// estos valores deben ser un array que debe estar asociado a los atributos del objeto,
//  por lo que primero asignamos los atributos.
  function __construct($data=null){
    parent::attr(array(
      'Id_Usuario'=>'id'
      ,'Nombre_Acceso'=>'username'
      ,'Clave_Acceso'=>'passw'
      ,'Tipo'=>'tipo_usu'
      ,'Correo'=>'correo'
      ,'Url_Imagen'=> 'foto_perfil'
      ,'Estado'=>''
      ,'Fecha_Cambio_Clave'=>'fechacambioc'));
      parent::__construct($data);
      parent::set_table('Usuario');
    }
}
?>
