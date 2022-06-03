<?PHP
defined('BASEPATH') OR exit('No direct script access allowed');
include_once (APPPATH.'core/MY_Obj.php'); //sumamanete necesario instancias la clase madre

class Token_obj extends MY_Obj{
//construimos el objeto, cuando se instancia con valores,
// estos valores deben ser un array que debe estar asociado a los atributos del objeto,
//  por lo que primero asignamos los atributos.
  function __construct($data=null){
    parent::attr(array(
      'Id_Token'=>''
      ,'Codigo_validacion'=>''
      ,'Fecha_Peticion'=>''
      ,'Token'=>''
      ,'Id_Usuario'=>''
      ,'Estatus'=>''));
      parent::__construct($data);
      parent::set_table('Token');
      parent::set_relation(array(
        'Id_Usuario'=>'Id_Usuario'));
    }
}
?>
