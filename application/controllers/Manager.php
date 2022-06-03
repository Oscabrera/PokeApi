<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \Mailjet\Resources;

class Manager extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('error');
        $this->load->helper('apoyos');
        $this->load->helper('funcionphp');
        $this->load->helper('curl');
        $this->load->helper('Logica/sessioncontrol');
        $this->load->model('Pokemon_model', 'Pokemonmodel');
        $this->load->model('Habilidades_model', 'habilidadesmodel');
        $this->load->model('Habilidad_Pokemon_model', 'HabilidadPokemonmodel');
        $this->load->model('Imagen_model', 'imagenmodel');

        
        date_default_timezone_set('America/Mexico_City');
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
    }


    public function index()
    {
        tiempo_muerto();

        $this->load->view('manager/head');
        $this->load->view('manager/menu');
        $this->load->view('manager/principal');
        $this->load->view('manager/footer');
        $this->load->view('login/sessioncheck');
        $this->load->view('manager/principaljs');
        $this->load->view('manager/findoc');
    }

    public function pokedexinit()
    {
        tiempo_muerto();

        $inicio = $_REQUEST['inicio'];
        $limite = $_REQUEST['limit'];
        $datos['pokes'] = array();

        for ($i = $inicio; $i <= $limite; $i++) {
            $pokedata = curlGet('https://pokeapi.co/api/v2/pokemon/' . $i);
            $poke = new $this->Pokemonmodel();
            $poke->d->id = $i;
            $poke->d->Estatus = '1';
            $buscado = $poke->buscar();
            $pokedata->interno = $buscado;
            $datos['pokes'][] = $pokedata;


        }

        $this->load->view('manager/Pokemons/principal', $datos);
        $this->load->view('manager/Pokemons/principaljs', $datos);
        $this->load->view('login/sessioncheck');
    }

    function actualizapokemon(){
        $arrayJSON = array('type' => 'error', 'msg' => 'No fue posible completar la solicitud.');

        $id = $_REQUEST['id'];
        $pokedata = curlGet('https://pokeapi.co/api/v2/pokemon/' . $id);
               $this->Pokemonmodel->d->id = $id;
        $buscado = $this->Pokemonmodel->buscar();

        $poke = new $this->Pokemonmodel();
        if($buscado == true){
            $poke->d->Nombre = $pokedata->name;
            $poke->d->Height = $pokedata->height;
            $poke->d->Weight = $pokedata->weight;
            $poke->d->Orden = $pokedata->order;
            $poke->d->Xp_Base = $pokedata->base_experience;
            $poke->d->Fecha_Modificacion = date('Y-m-d H:i:s');
            $poke->d->Estatus = '1';
            $arcondicion = array('id'=> $id);
            $idpokemon = $poke->Actualiar($arcondicion);
        }else{
            $poke->d->id = $id;
            $poke->d->Nombre = $pokedata->name;
            $poke->d->Height = $pokedata->height;
            $poke->d->Weight = $pokedata->weight;
            $poke->d->Orden = $pokedata->order;
            $poke->d->Xp_Base = $pokedata->base_experience;
            $poke->d->Fecha_Registro = date('Y-m-d H:i:s');
            $poke->d->Fecha_Modificacion = date('Y-m-d H:i:s');
            $poke->d->Estatus = '1';
            $idpokemon = $poke->insertar();
        }

            if( $id > 0 ){
                foreach($pokedata->abilities as $K => $V){
                    $habilidad = new $this->habilidadesmodel();
                    $this->habilidadesmodel->h->Nombre = $V->ability->name;
                    $idhabilidad = 0;
                    $datahabilidadesmodel =$this->habilidadesmodel->buscar();

                    if($this->habilidadesmodel->buscar() == false){
                        $habilidad->h->Nombre = $V->ability->name;
                        $habilidad->h->Fecha_Modificacion = date('Y-m-d H:i:s');
                        $habilidad->h->Estatus = '1';
                        $habilidad->h->Fecha_Registro = date('Y-m-d H:i:s');
                        $idhabilidad = $habilidad->insertar();
                    }else{
                        $habilidad->h->Nombre = $V->ability->name;
                        $habilidad->h->Fecha_Modificacion = date('Y-m-d H:i:s');
                        $habilidad->h->Estatus = '1';
                        $arcondicion = array('id'=> $this->habilidadesmodel->h->id);
                        $habilidad->Actualiar($arcondicion);
                        $idhabilidad = $this->habilidadesmodel->h->id;
                    }
                    if($idhabilidad>0){
                        $habilidadpoke = new $this->HabilidadPokemonmodel();
                        $this->HabilidadPokemonmodel->hp->id_Pokemon = $id;
                        $this->HabilidadPokemonmodel->hp->id_Habilidad = $idhabilidad;


                        if($this->HabilidadPokemonmodel->buscar() == false){
                            $habilidadpoke->hp->id_Pokemon = $id;
                            $habilidadpoke->hp->id_Habilidad = $idhabilidad;
                            $habilidadpoke->hp->Oculta = ($V->is_hidden == true) ? '1' : '0';
                            $habilidadpoke->hp->Fecha_Modificacion = date('Y-m-d H:i:s');
                            $habilidadpoke->hp->Estatus = '1';
                            $habilidadpoke->hp->Fecha_Registro = date('Y-m-d H:i:s');
                            $idhabilidadpoke = $habilidadpoke->insertar();
                        }else{
                            $habilidadpoke->hp->id_Pokemon = $id;
                            $habilidadpoke->hp->id_Habilidad = $idhabilidad;
                            $habilidadpoke->hp->Oculta = ($V->is_hidden == true) ? '1' : '0';
                            $habilidadpoke->hp->Fecha_Modificacion = date('Y-m-d H:i:s');
                            $habilidadpoke->hp->Estatus = '1';
                            $arcondicion = array('id'=> $this->HabilidadPokemonmodel->hp->id);
                            $habilidadpoke->Actualiar($arcondicion);
                        }
                    }

                    $this->arregloimagenes('',$pokedata->sprites,$id);
                }
                $arrayJSON = array('type' => 'success', 'msg' => 'Se registro los datos');
            }


        echo json_encode($arrayJSON);
    }

    function sendemail(){
        $arrayJSON = array('type' => 'success', 'msg' => 'Se registro los datos');
        $id = $_REQUEST['id'];
        $datos = array();
        $pokedata = curlGet('https://pokeapi.co/api/v2/pokemon/' . $id);
        $datos['nombre'] = $pokedata->name;
        $datos['height'] = $pokedata->height;
        $datos['weight'] = $pokedata->weight;
        $datos['order'] = $pokedata->order;
        $datos['base_experience'] = $pokedata->base_experience;

        $img = (array) $pokedata->sprites->other;
        $datos['img'] = $img['official-artwork']->front_default;

        foreach($pokedata->abilities as $K => $V){
            $habilidad[] = array($V->ability->name,$V->is_hidden);
        }
        $datos['habilidad'] = $habilidad;

        $vista = $this->load->view('manager/Pokemons/vistaCorreo', $datos,true);
        $this->enviarCorreo('sistemas@paruno.mx',$vista);
        echo json_encode($arrayJSON);
    }

    function borrarpokemon(){
        $arrayJSON = array('type' => 'error', 'msg' => 'No fue posible completar la solicitud.');
        $id = $_REQUEST['id'];
        $this->Pokemonmodel->d->id = $id;
        $buscado = $this->Pokemonmodel->buscar();

        if($buscado == true){
            $poke = new $this->Pokemonmodel();
            $poke->d->Fecha_Modificacion = date('Y-m-d H:i:s');
            $poke->d->Estatus = '0';
            $arcondicion = array('id'=> $id);
            $idpokemon = $poke->Actualiar($arcondicion);
            if( $idpokemon > 0 ){
                $arrayJSON = array('type' => 'success', 'msg' => 'Se registro los datos');
            }
        }

        echo json_encode($arrayJSON);
    }

    function enviarCorreo($correo, $vista)
    {
        $mj = new \Mailjet\Client(
            '33980805d0b11442c0bd133c59517b41',
            'f03b19d8180e1785ce4590e69bac0d0c', true,
            ['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "edesarrollosfw@gmail.com"
                    ],
                    'To' => [
                        [
                            'Email' => $correo
                        ]
                    ],
                    'Subject' => 'Información para acceso',
                    'HTMLPart' => $vista,
                    'CustomID' => "AppGettingStartedTest"
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
    }


    function arregloimagenes($sub, $spritessub,$poke){
        foreach ($spritessub as $K => $V) {
            if($V != null) {
                if (is_string($V)) {
                    $this->guardardatofoto($sub.$K,$V,$poke);
                } else {
                    $this->arregloimagenes($sub.$K,$V,$poke);
                }
            }
        }
    }

    function guardardatofoto($name,$url,$poke){

        $this->imagenmodel->i->id_Pokemon = $poke;
        $this->imagenmodel->i->Nombre = $name;
        $idhabilidad = 0;
        if($this->imagenmodel->buscar() == false){
            $this->imagenmodel->i->url = $url;
            $this->imagenmodel->i->Fecha_Modificacion = date('Y-m-d H:i:s');
            $this->imagenmodel->i->Fecha_Registro = date('Y-m-d H:i:s');
            $this->imagenmodel->i->Estatus = '1';
            $idhabilidad = $this->imagenmodel->insertar();
        }else{
            $this->imagenmodel->i->url = $url;
            $this->imagenmodel->i->Fecha_Modificacion = date('Y-m-d H:i:s');
            $this->imagenmodel->i->Estatus = '1';
            $arcondicion = array('id'=> $this->imagenmodel->i->id);
            $this->imagenmodel->Actualiar($arcondicion);
            $idhabilidad = $this->habilidadesmodel->h->id;
        }
        return $idhabilidad;
    }





}
