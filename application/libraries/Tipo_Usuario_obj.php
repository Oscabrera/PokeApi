<?PHP
defined('BASEPATH') OR exit('No direct script access allowed');
include_once (APPPATH.'core/MY_Obj.php'); //sumamanete necesario instancias la clase madre

class Tipo_Usuario_obj extends MY_Obj{
//construimos el objeto, cuando se instancia con valores,
// estos valores deben ser un array que debe estar asociado a los atributos del objeto,
//  por lo que primero asignamos los atributos.
  function __construct($data=null){
    parent::attr(array(
      'Id_Tipo_Usuario'=>'id_tipo_usu'
      ,'Nombre'=>'tipo_usu_nombre'
      ,'Descripcion'=>'tipo_usu_desc'
      ,'Estado'=>''
    ));
      parent::__construct($data);
      parent::set_table('Tipo_Usuario');
    }
}
?>
