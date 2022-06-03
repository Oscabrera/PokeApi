<?PHP
//comentario
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Obj{
    private $table = '';
    //Array para los atributos del objeto,
    //  para mejor funcionalidad usar claves de base de datos
    private $attributes = array();
    //Array para guardar la configuracion del objeto.
    private $data = array();
    //Array para guardar la configuracion de relación del objeto con otros objetos.
    private $relations = array();
    //Sincroniza los atributos al array attributes, se espera un arreglo asociativo clave y vista
    //attr espera array('BD'=>'vista'...);
    //  donde BD es el nombre del attributo en base de datos
    //    y vista el nombre del elemento en la vista.
    function attr($attr){ if(count($this->attributes)==0) $this->attributes=$attr; }
    // guarda y recupera la tabla donde debe ingresar los valores de base de datos.
    function set_table($table){ $this->table=$table; }
    function get_table(){ return $this->table; }
    //guardar datos en la variable privada data.
    //   revisa si existe oincidencia en la construccion de data
    //    los atributos del objeto los permite de otra forma lo rechaza.
    function __construct($data=null){
      if(is_array($data)){
        $arrayKeyVal=array_keys($this->attributes);
        foreach( $data as $key => $value){
          if(in_array($key,$arrayKeyVal)!=false) $this->data[$arrayKeyVal[array_search($key,$arrayKeyVal)]]=$value;
        }
      }else{ $this->data = null; }
      return $this;
    }
    //Guardar el valor de elemento deseado
    //  revisa si existe la clave que se desea guardar en los attributos
    //  de existir continua con la asignación, de otra forma la rechaza.
    public function __set($name, $value){
      if(!is_array($value)){
        if(in_array($name,array_keys($this->attributes))) $this->data[$name] = $value;
      }
    }
    public function forzarset($name, $value){
      $this->data[$name] = $value;
    }

    //recuperar el valor de elemento
    public function __get($name){ return (isset($this->data[$name])) ? $this->data[$name] : ''; }
    //Obtener todos los valores desde el array POST
    //  revisamos si algunos de los atributos se encuenstra en al arreglo de $input.
    public function set_post($input){
      foreach($this->attributes as $key=>$elem){
        if($input->post($elem)!=null) $this->data[$key] = $input->post($elem);
      }
      //regresamos la instancia para mejorar llamadas
      return $this;
    }
    //comvierte un stdClass a array
    //  principal utilidad es recolectar datos de base de datos y guardar en data
    public function set_objectBD($obj){
      $arrayKeyVal=array_keys($this->attributes);
        foreach ($obj as $key => $value){
          if(!is_array($value)){
            if(in_array($key,$arrayKeyVal)) $this->data[$key] = trim($value);
          }
        }
        //regresamos la instancia para mejorar llamadas
        return $this;
    }
    //Obtener todos los valores desde un objeto
    //  revisamos si algunos de los atributos se encuenstra en al arreglo.
    public function set_object($object){
      $arrayKeyVal=array_keys($this->attributes);
      $arrayVal=array_values($this->attributes);
      foreach ($object as $key => $value) {
        if(($attr=array_search($key,$arrayVal))!=false){
          $this->data[$arrayKeyVal[$attr]]=trim($value);
        }
      }
      //regresamos la instancia para mejorar llamadas
      return $this;
    }

    // recuperar array data completo en forma de array; //tostring :p
    public function get_all(){return $this->data;}


    public function get_allNotNUll(){
        $arrayKeyVal=array_keys($this->data);
        $dataNotNUll = array();
        foreach ($this->data as $key => $value){
            if($value!=null){
                $dataNotNUll[$key] = $value;
            }
        }
        //regresamos la instancia para mejorar llamadas
        return $dataNotNUll;
    }

    //Motodo comvinado que recoje el input llamando al metodo set_post
    // regresa el arreglo solucion usando el metodo get_all.
    public function get_input($input){
        return $this->set_post($input)->get_all();
    }
    //Metodo para asignar las relaciones
    function set_relation($relacion){ if(count($this->relations)==0) $this->relations=$relacion; }
    //function get_table(){ return $this->table; }
    //Agrega los valores que se encunestren en relación
    public function set_relacion($values){
        $arKval=array_keys($values);
        $i=0;
        foreach($values as $elem){
            $e=array_search($arKval[$i],$this->relations);
            if($e!=''){
                  $this->data[$e]=$elem;
            }
            $i++;
        }
    }

    public function get_attributes(){
      return $this->attributes;
    }
}
?>
