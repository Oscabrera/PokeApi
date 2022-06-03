<?php
// --------------------------------------------------------------------------------
// CALCURP Libreria - calcurp.lib.php
// --------------------------------------------------------------------------------
// Licensed under The MIT License
// Redistributions of files must retain the above copyright notice.
// http://blog.compuram.com.mx
// --------------------------------------------------------------------------------
//
// Presentacion :
//   calcurp es una libreria PHP que permite generar los primeros 16 digitos
//	 de los 18 que conforman la CURP. El calculo se basa en lo descrito en el
//   "Instructivo para la Asignación de la Clave Única de Registro de Población"
//   (http://www.registrocivil.gob.mx/html/InstructivoParaLaCurp.pdf).
//
//
//
/**
 * CALCULO DE CURP
 * ---
 * Escrito por Jose Ramon Perez <ramelp@gmail.com>
 * Copyright (c) 2007-2008, J. Ramon Perez <ramelp@gmail.com>
 *
 *
 *
 * @autor           Jose Ramon Perez <ramelp@gmail.com>
 * @paquete         CALCURP
 * @copyright       Copyright (c) 2007-2008, Jose Ramon Perez <ramelp@gmail.com>
 * @link            http://blog.compuram.com.mx
 * @id              $Id: calcurp.lib.php 001 2008-06-08 01:17:28 ramel $
 * @version         $0.1$
 * @license         http://www.opensource.org/licenses/mit-license.php The MIT License
 *
 */
class calcurp
{

	public function __construct() {	}
 	  //
	  var $nom="";
	  var $ap1="";
	  var $ap2="";
	  var $dia="";
	  var $mes="";
	  var $anio="";
	  var $sexo="";
	  var $edo="";
	  var $curp="";


 	  function calcurp($ap="",$am="",$n="",$y="",$m="",$d="",$s="",$e="")
 	  {


 	   		$this->nom=mb_strtoupper(trim($n));
 	   		$this->ap1=mb_strtoupper(trim($ap));
 	   		$this->ap2=mb_strtoupper(trim($am));
			$this->dia=mb_strtoupper(trim($d));
 	   		$this->mes=mb_strtoupper(trim($m));
 	   		$this->anio=mb_strtoupper(trim($y));
			$this->sexo=mb_strtoupper(trim($s));
			$this->edo=mb_strtoupper(trim($e));

			$this->dieresis();
			$this->limpia_espacios();
 	  		$this->criterios_excepcion();
			$this->integra_curp();

			return $this;
 	  }

	  function criterios_excepcion()
	  {
	   		   	$this->partes_compuestas();
				$this->verifica_apellidos();
				$this->nombre_compuesto();
				$this->partes_compuestas();
				$this->dieresis();
				$this->letra_inicial();

	  }

	  function integra_curp()
	  {
	   		   $this->cuatro_letras();

			   $this->caracteres_especiales();
    		   $this->palabras_inconvenientes();
			   $this->fecha_nacimiento();
			   $this->persona_sexo();
			   $this->persona_estado();
			   $this->consonantes_internas();

	  }
	  /****************************************
	  Consonantes Internas:Integradas  por  las  primeras  consonantes  internas  del  primer
		apellido, segundo apellido y nombre (alfabetica).
	  ******************************************/
	  function consonantes_internas()
	  {

	  		$this->letras_internas($this->ap1);
			$apellidos=$this->numero_apellidos();
			if($apellidos==2)
				$this->letras_internas($this->ap2);
			else
				$this->curp.="X";

			$this->letras_internas($this->nom);


	  }
	  /*****************************
	  --Cuando  la  primera  consonante  interna  es  la  letra Ñ. El  sistema
  	  asignara una "X". 	Ejemplo:  ALBERTO OÑATE RODRIGUEZ   XDL
	  --Cuando no existen consonantes internas en nombre o apellido.
		El sistema asignar· una ìXî en la posiciÛn correspondiente.
		Ejemplo: ANDRES PO BARRIOS  XRN
	  --Con    un  solo  apellido.    La  aplicacion  asignara  una  "X"  en  la
		posicion 15.
		Ejemplo: LETICIA LUNA  NXT
		--Cuando  el  nombre  sea  compuesto  (formado  por  dos  o  m·s
		palabras), la clave se construye con la primera consonante interna
		del  primer  nombre,  siempre  y  cuando  no  sea Maria  o  Jose,  en
		cuyo caso se utilizar· el  segundo nombre.
	  ******************************/
	  function letras_internas($cadena)
	  {

	  		$consonantes = array("B","C","D","F","G","H","J","K","L","M","N","Ñ",
								  "P","Q","R","S","T","V","W","X","Y","Z",".");
			$consonante="";

			for ($i=1;$i<$this->str_tam($cadena);$i++){
				if (in_array(mb_substr($cadena,$i,1),$consonantes) || mb_substr($cadena,$i,1)==' ')
				{
					$consonante = mb_substr($cadena,$i,1);
					break;
				}
			}


	   		if($this->str_tam($consonante)==1)
			{
				if($consonante == 'Ñ' || $consonante==' ')
				{
	   		   			$consonante="X";
				}
				if($this->str_compara($consonante,".")==0 )
				{
	   		   			$consonante="X";
				}
   				$this->curp.=$consonante;
			}
	   		else
	  			$this->curp.="X";

	  		$this->limpia_cadenas();
	  }
	    //asignacion del estado de nacimiento de la persona a la curp.
	  function persona_estado()
	  {
	  	$estados=array("AS","BC","BS","CC","CL","CM","CS","CH","DF","DG","GT","GR",
						"HG","JC","MC","MN","MS","NT","NE","NL","OC","PL","QT","QR","SP",
						"SL","SR","TC","TS","TL","VZ","YN","ZS","NE");
	  	if($this->str_tam($this->edo)==2)
				$this->curp.=trim($this->edo);
		elseif(in_array ($this->edo, $estados))
		{
			die('ERROR EN CALCULO DE CURP POR FAVOR VERIFIQUE: EL CAMPO "ESTADO DE NACIMIENTO".');
		}
		else
		{
			die('ERROR EN CALCULO DE CURP POR FAVOR VERIFIQUE: EL CAMPO "ESTADO DE NACIMIENTO".');
		}

	  }
	   //asignacion del sexo de la persona a la curp.
	  //se aplica formato de fecha
	  function persona_sexo()
	  {
	  	if(!$this->str_tam($this->sexo)==1)
			die('ERROR EN CALCULO DE CURP POR FAVOR VERIFIQUE: EL CAMPO "SEXO".');
	  	$this->curp.=trim($this->sexo);
	  }
	  //asignacion de la fecha de nacimiento al curp.
	  //se aplica formato de fecha
	  function fecha_nacimiento()
	  {
	  	$fecha=$this->anio."-".$this->mes."-".$this->dia;
		$fnac=date("ymd", strtotime($fecha));
		$this->curp.=$fnac;
	  }
	  /*********************************
	  Si  en  los  apellidos  o  en  el  nombre  aparecieran  caracteres
	  especiales como diagonal  (/), guion  (-),  o punto (.), se captura tal
	  cual viene en el documento probatorio y la aplicacion asignara una
	  X  en  caso  de  que  esa  posicion  intervenga  para  la  conformacion
	  de la clave.
	  Ejemplo:  JUAN JOSE D/AMICO ALVAREZ  DXAJ
	  *********************************/
	  function caracteres_especiales()
	  {
	      $caracteres=array("/","-",".");
		  $this->curp=str_replace($caracteres,"X",$this->curp);

	  	  $this->limpia_cadenas();

	  }

	  /****************************
	  Si  de  las  cuatro  letras  resulta  una  palabra  altisonante  .
	   La segunda letra sera sustituida por una "X".
	  Ejemplo: OFELIA PEDRERO DOMINGUEZ   PXDO

	  ******************************/

	  function palabras_inconvenientes()
	  {
	     $palabras=array("BXCA"=>"BACA","BXKA"=>"BAKA","BXEI"=>"BUEI","BXEY"=>"BUEY","CXCA"=>"CACA","CXCO"=>"CACO","CXGA"=>"CAGA",
				     "CXGO"=>"CAGO","CXKA"=>"CAKA","CXKO"=>"CAKO","CXGE"=>"COGE","CXGI"=>"COGI","CXJA"=>"COJA","CXJE"=>"COJE",
				     "CXJI"=>"COJI","CXJO"=>"COJO","CXLA"=>"COLA","CXLO"=>"CULO","FXLO"=>"FALO","FXTO"=>"FETO","GXTA"=>"GETA",
				     "GXEI"=>"GUEI","GXEY"=>"GUEY","JXTA"=>"JETA","JXTO"=>"JOTO","KXCA"=>"KACA","KXCO"=>"KACO","KXGA"=>"KAGA",
				     "KXGO"=>"KAGO","KXKA"=>"KAKA","KXKO"=>"KAKO","KXGE"=>"KOGE","KXGI"=>"KOGI","KXJA"=>"KOJA","KXJE"=>"KOJE",
				     "KXJI"=>"KOJI","KXJO"=>"KOJO","KXLA"=>"KOLA","KXLO"=>"KULO","LXLO"=>"LILO","LXCA"=>"LOCA","LXCO"=>"LOCO",
				     "LXKA"=>"LOKA","LXKO"=>"LOKO","MXME"=>"MAME","MXMO"=>"MAMO","MXAR"=>"MEAR","MXAS"=>"MEAS","MXON"=>"MEON",
				     "MXAR"=>"MIAR","MXON"=>"MION","MXCO"=>"MOCO","MXKO"=>"MOKO","MXLA"=>"MULA","MXLO"=>"MULO","NXCA"=>"NACA",
				     "NXCO"=>"NACO","PXDA"=>"PEDA","PXDO"=>"PEDO","PXNE"=>"PENE","PXPI"=>"PIPI","PXTO"=>"PITO","PXPO"=>"POPO",
				     "PXTA"=>"PUTA","PXTO"=>"PUTO","QXLO"=>"QULO","RXTA"=>"RATA","RXBA"=>"ROBA","RXBE"=>"ROBE","RXBO"=>"ROBO",
				     "RXIN"=>"RUIN","SXNO"=>"SENO","TXTA"=>"TETA","VXCA"=>"VACA","VXGA"=>"VAGA","VXGO"=>"VAGO","VXKA"=>"VAKA",
				     "VXEI"=>"VUEI","VXEY"=>"VUEY","WXEI"=>"WUEI","WXEY"=>"WUEY");
	  		$bool=array_search($this->curp,$palabras);
			if($bool)
				$this->curp=$bool;



	  }
	  /**************************
	  La letra inicial y la primera vocal interna del primer apellido, la letra
	  inicial  del  segundo  apellido  y  la  primera  letra  del  nombre.  En  el
	  caso  de  las  mujeres  casadas,  se  deberan  usar  los  apellidos  de
	  soltera (alfabetica).
	  **************************/
	  function cuatro_letras()
	  {

	   		$this->caracteres_ap1();
			$this->caracteres_ap2();
			$this->caracteres_nom();

	  }
	  /***********************************
	  Con  dos  apellidos,  si  el  primer  apellido  no  tiene  vocal  interna.
	   Para la construccion de la CURP el sistema asignara una "X" en la
	   segunda posicion.
	  **********************************/
	  function caracteres_ap1()
	  {
	   		$vocales = array("I","A","E","O","U","/","-",".");
			$vocal="";
			$this->curp.=substr($this->ap1, 0, 1);
			for ($i=1;$i<$this->str_tam($this->ap1);$i++)
				if (in_array(substr($this->ap1,$i,1),$vocales))
				{
					$vocal = substr($this->ap1,$i,1);
					break;
				}

	   		if($this->str_tam($vocal)==1)
	   			$this->curp.=$vocal;
	   		else
	  			$this->curp.="X";

	  		$this->limpia_cadenas();

	  }
	  function caracteres_ap2()
	  {
	   		$apellidos=$this->numero_apellidos();
	   		if($apellidos==1)
	   		   $this->curp.="X";
	   		elseif($apellidos==2)
	   		   $this->curp.=substr($this->ap2, 0, 1);
	   		else
	   			die("ERROR EN CALCULO DE CURP POR FAVOR VERIFIQUE: LOS APELLIDOS DE LA PERSONA");


	   		$this->limpia_cadenas();
	  }
	  function caracteres_nom()
	  {
	   		   $this->curp.=substr($this->nom, 0, 1);
	  	  	   $this->limpia_cadenas();

	  }
	  //Permite determinar el numero de apellidos en el nombre completo
	  //para aplicar algunas excepciones
	  function numero_apellidos()
	  {
	   		$apellidos=0;
			if($this->str_tam($this->ap1)>0 &&  $this->ap1!="")
				$apellidos++;
			if($this->str_tam($this->ap2)>0 &&  $this->ap2!="")
				$apellidos++;

			return $apellidos;
	  }

	  /********************************************************
	  	Cuando  alguno  de  los  apellidos  o  nombre  es  compuesto  y  la
		primera  palabra  de  esta  composicion  es  una  preposicion,
		conjuncion, contraccion (DA, DAS, DE, DEL, DER, DI, DIE, DD,
		EL,  LA,  LOS,  LAS,  LE,  LES,  MAC,  MC,  VAN,  VON,  Y).  La
		aplicacion  elimina  la  primera  palabra  y  utiliza  la  siguiente  del
		apellido o nombre.
		Ejemplo: CARLOS MC GREGOR LOPEZ   GELC
	  ******************************************************/
	  function partes_compuestas()
	  {
		  $excepciones = array(" DA "," DAS "," DE "," DEL "," DER "," DI "," DIE "," DD "," EL "," LA "," LOS "," LAS "," LE "," LES "," MAC "," MC "," VAN "," VON "," Y ");
		  if($this->es_compuesto($this->nom))
		  {
			$this->nom=" ".$this->nom;
			$this->nom=str_replace( $excepciones  , " "  , $this->nom);
		  }
		  if($this->es_compuesto($this->ap1))
		  {
			$this->ap1=" ".$this->ap1;
			$this->ap1=str_replace( $excepciones  , " "  , $this->ap1);

		  }
		  if($this->es_compuesto($this->ap2))
		  {
			$this->ap2=" ".$this->ap2;
		  	$this->ap2=str_replace( $excepciones  , " "  , $this->ap2);

		  }
		  $this->limpia_cadenas();
	  }
	  /***********************************
	  Cuando  se  presentan  diéresis  (¨)  en    nombres  o  apellidos,  habrá
	  que omitirlas.
	  Ejemplo:   ARGÜELLO  ARGUELLO
	  *********************************/
	  function dieresis()
	  {
		  $from=array('Ä','Ë','Ï','Ö','Ü');
		  $to=array('A','E','I','O','U');
		  $this->nom=str_replace($from, $to, $this->nom);
		  $this->ap1=str_replace($from, $to, $this->ap1);
		  $this->ap2=str_replace($from, $to, $this->ap2);

		  $from=array('Á','É','Í','Ó','Ú');
		  $to=array('A','E','I','O','U');

		  $this->nom=str_replace($from, $to, $this->nom);
		  $this->ap1=str_replace($from, $to, $this->ap1);
		  $this->ap2=str_replace($from, $to, $this->ap2);



	 }

	  /**************************
	  Cuando  el  nombre  sea  compuesto  (formado  por  dos  o  mas palabras),  la  clave
	  se  construye  con  la  letra  inicial  de  la  primera palabra, siempre que no sea:
	  MARIA, MA., MA, o JOSE, J, J. en cuyo caso se utilizará la segunda palabra.
	  se agrego M. y M

	  ************************/
	  function nombre_compuesto()
	  {
		  $excepciones = array("JOSE ","MARIA ","J ","MA ","J. ","MA. ","M ","M. ");
		  if($this->es_compuesto($this->nom))
		  {
		  	$this->nom=str_replace( $excepciones  , ""  , $this->nom);
			$this->limpia_cadenas();
		  }

	  }
	  //Determina si una de las partes del nombre es compuesta
	  function es_compuesto($cadena)
	  {
			$espacios=0;
			$pos_espacios=0;
			$espacios=substr_count($cadena," ");
			$pos_espacios=strpos($cadena, " ");
			if($espacios >0 && ($pos_espacios>0 && $pos_espacios<$this->str_tam($cadena)))
				return 1;
			else
				return 0;
	  }

	  /*********************************************
		 Si la  letra  inicial de alguno de  los apellidos o del nombre es Ñ,
		 el sistema asignara una "X" en su lugar.
		     Ejemplo:     ALBERTO ÑANDO RODRIGUEZ   XARA
		********************************************/
	  function letra_inicial()
	  {
	   		    if($this->str_tam($this->nom)>0)
	   		   		if($this->str_compara(substr($this->nom,0,1),"Ñ")==0)
	   		   			$this->nom=$this->str_reemplaza_pos($this->nom,"X",0,1);
	   		   if($this->str_tam($this->ap1)>0)
	   		   		if($this->str_compara(substr($this->ap1,0,1),"Ñ")==0)
	   		   			$this->ap1=$this->str_reemplaza_pos($this->ap1,"X",0,1);
	   		   if($this->str_tam($this->ap2)>0)
	   		   		if($this->str_compara(substr($this->ap2,0,1),"Ñ")==0)
	   		   			$this->ap2=$this->str_reemplaza_pos($this->ap2,"X",0,1);
	  			$this->limpia_cadenas();

	  }

	  //Verificar numero de  apellidos. Si solo existe 1 apellido entonces
	  //se debera verificar que este sea  ap1.
	  function verifica_apellidos()
	  {
		  if($this->str_tam($this->ap1)==0 || $this->str_tam($this->ap2)==0)
		  		if($this->str_tam($this->ap1)==0 && $this->str_tam($this->ap2)>0)
		  		{
		  				$this->ap1=$this->ap2;
		  				$this->ap2="";

		  		}
		  $this->limpia_cadenas();
	  }

	  //reemplaza una cadena con otra dada una posicion
	  function str_reemplaza_pos($cadena,$cadena_sustituta,$comienzo,$longitud)
	  {
	  	   	 $sub_cadena=substr_replace  ($cadena  ,$cadena_sustituta  , $comienzo ,$longitud );
			 return $sub_cadena;
	  }
	  //compara dos cadenas
	  function str_compara($cadena1=" ",$cadena2="")
	  {
	   		   $bool=strcmp($cadena1,$cadena2);
	   		   return $bool;

	  }
	  //devuelve el tamano de la cadena enviada
	  function str_tam($cadena)
	  {
	   		$tam=strlen($cadena);
	  		return $tam;
	  }
	  //limpiar espacios en blanco dentro de las partes del nombre
	  function limpia_cadenas()
	  {
		  $this->nom=trim($this->nom);
		  $this->ap1=trim($this->ap1);
		  $this->ap2=trim($this->ap2);
		  $this->curp=trim($this->curp);

	  }
	   //limpiar espacios en blanco dentro de los nombres valida para 2,3,4,5 espacios(pendiente optimizar)
	  function limpia_espacios()
	  {

		  //$no_palabras=str_word_count($this->nom);
		 // for($i=0;)
		 // $nombre=str_word_count($this->nom, 1);
		  return ;

	  }
	  //Mostrar resultado en pantalla
	  // --------------------------------------------------------------------------------
	   // Function : imprime()
 	   // Description :
  	   //   Imprime los 16 digitos de la curp calculada
      // Parametros :
     // Regresa Valor :
  // --------------------------------------------------------------------------------
	  function imprime()
	  {
	    echo $this->curp;


	  }
	  //Regresar curp calculada
	  // --------------------------------------------------------------------------------
	   // Function : regresa()
 	   // Description :
  	   //   regresa una variable tipo string con los 16 digitos de la curp calculada
      // Parametros :
     // Regresa Valor : String 16 digitos
  // --------------------------------------------------------------------------------
	  function regresa()
	  {

	  	return $this->curp;

	  }

}

//----- para utilizar la clase ----------
// ---- $rfc=new calcurp("MARTINEZ","ALMANZA","MA.CONSUELO","1971","07","18","M","GT");
// ------------------------------------------------------------------------------------

//$rfc2=new calcurp("OÑATE","SANCHEZ","MA DE LOS ANGELES","1982","12","10","M","GT");
//$rfc3=new calcurp("LAGUNA","YA","JEOVANI","1982","12","10","M","GT");
//$rfc4=new calcurp("D/AMICO","ALVAREZ","JUAN JOSE");MAMR710718MGTRCS25

// ------ salida ----------------------
// --- $rfc->imprime();
// ------------------------------------
//echo "<br>";
//$rfc2->imprime();
//echo "<br>";
//$rfc3->imprime();
//echo "<br>";
//$rfc4->imprime();
?>
