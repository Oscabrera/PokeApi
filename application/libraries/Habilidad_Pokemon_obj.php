<?PHP
defined('BASEPATH') OR exit('No direct script access allowed');
include_once (APPPATH.'core/MY_Obj.php'); //sumamanete necesario instancias la clase madre

class Habilidad_Pokemon_obj extends MY_Obj{
//construimos el objeto, cuando se instancia con valores,
// estos valores deben ser un array que debe estar asociado a los atributos del objeto,
//  por lo que primero asignamos los atributos.
  function __construct($data = null)
  {

    parent::attr(array(
      'id' => '',
      'id_Pokemon' => 'id_Pokemon',
      'id_Habilidad' => 'id_Habilidad',
      'Oculta' => 'Oculta',
      'Fecha_Registro' => 'fecha_registro',
      'Fecha_Modificacion' => 'fecha_modificacion',
      'Estatus' => 'estatus',
    ));
    parent::__construct($data);
    parent::set_table('PokeApp.Habilidad_Pokemon');
  }
}

?>
