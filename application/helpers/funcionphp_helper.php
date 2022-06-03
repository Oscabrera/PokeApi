<?PHP
//no importa formato, debe ser fecha (preferente base datos o date php)
function FechaLetra($fecha,$format=0){
  $meses = array('','enero','febrero','marzo','abril','mayo','junio','julio',
  'agosto','septiembre','octubre','noviembre','diciembre');

  $dia = array('domingo','lunes','martes','miércoles','jueves','viernes','sábado');
  if($fecha!='--'){
      if($format==1){
          return $dia[date("w", strtotime($fecha))].' '.
              date("d", strtotime($fecha)).' de '.
              $meses[date("n", strtotime($fecha))].' de '.
              date("Y", strtotime($fecha));

      }
      elseif($format==2){
          return mb_strtolower(convertir(date("d", strtotime($fecha)))).' del mes '.
              $meses[date("n", strtotime($fecha))].' del año '.
              mb_strtolower(convertir(date("Y", strtotime($fecha))));
      }
      else{
          return $dia[date("w", strtotime($fecha))].' '.
              date("d", strtotime($fecha)).' de '.
              $meses[date("n", strtotime($fecha))].' de '.
              date("Y", strtotime($fecha)).' '.
              date("G:i", strtotime($fecha));
      }
  }else{
      return 'Sin información';
  }

}

function obtener_edad($fecha_nacimiento) {
    $tiempo = strtotime($fecha_nacimiento);
    $ahora = time();
    $edad = ($ahora-$tiempo)/(60*60*24*365.25);
    $edad = floor($edad);
    return $edad;
}

function unidad($numuero){
    switch ($numuero)
    {
        case 9:
            {
                $numu = "NUEVE";
                break;
            }
        case 8:
            {
                $numu = "OCHO";
                break;
            }
        case 7:
            {
                $numu = "SIETE";
                break;
            }
        case 6:
            {
                $numu = "SEIS";
                break;
            }
        case 5:
            {
                $numu = "CINCO";
                break;
            }
        case 4:
            {
                $numu = "CUATRO";
                break;
            }
        case 3:
            {
                $numu = "TRES";
                break;
            }
        case 2:
            {
                $numu = "DOS";
                break;
            }
        case 1:
            {
                $numu = "UNO";
                break;
            }
        case 0:
            {
                $numu = "";
                break;
            }
    }
    return $numu;
}

function decena($numdero){

    if ($numdero >= 90 && $numdero <= 99)
    {
        $numd = "NOVENTA ";
        if ($numdero > 90)
            $numd = $numd."Y ".(unidad($numdero - 90));
    }
    else if ($numdero >= 80 && $numdero <= 89)
    {
        $numd = "OCHENTA ";
        if ($numdero > 80)
            $numd = $numd."Y ".(unidad($numdero - 80));
    }
    else if ($numdero >= 70 && $numdero <= 79)
    {
        $numd = "SETENTA ";
        if ($numdero > 70)
            $numd = $numd."Y ".(unidad($numdero - 70));
    }
    else if ($numdero >= 60 && $numdero <= 69)
    {
        $numd = "SESENTA ";
        if ($numdero > 60)
            $numd = $numd."Y ".(unidad($numdero - 60));
    }
    else if ($numdero >= 50 && $numdero <= 59)
    {
        $numd = "CINCUENTA ";
        if ($numdero > 50)
            $numd = $numd."Y ".(unidad($numdero - 50));
    }
    else if ($numdero >= 40 && $numdero <= 49)
    {
        $numd = "CUARENTA ";
        if ($numdero > 40)
            $numd = $numd."Y ".(unidad($numdero - 40));
    }
    else if ($numdero >= 30 && $numdero <= 39)
    {
        $numd = "TREINTA ";
        if ($numdero > 30)
            $numd = $numd."Y ".(unidad($numdero - 30));
    }
    else if ($numdero >= 20 && $numdero <= 29)
    {
        if ($numdero == 20)
            $numd = "VEINTE ";
        else
            $numd = "VEINTI".(unidad($numdero - 20));
    }
    else if ($numdero >= 10 && $numdero <= 19)
    {
        switch ($numdero){
            case 10:
                {
                    $numd = "DIEZ ";
                    break;
                }
            case 11:
                {
                    $numd = "ONCE ";
                    break;
                }
            case 12:
                {
                    $numd = "DOCE ";
                    break;
                }
            case 13:
                {
                    $numd = "TRECE ";
                    break;
                }
            case 14:
                {
                    $numd = "CATORCE ";
                    break;
                }
            case 15:
                {
                    $numd = "QUINCE ";
                    break;
                }
            case 16:
                {
                    $numd = "DIECISEIS ";
                    break;
                }
            case 17:
                {
                    $numd = "DIECISIETE ";
                    break;
                }
            case 18:
                {
                    $numd = "DIECIOCHO ";
                    break;
                }
            case 19:
                {
                    $numd = "DIECINUEVE ";
                    break;
                }
        }
    }
    else
        $numd = unidad($numdero);
    return $numd;
}

function centena($numc){
    if ($numc >= 100)
    {
        if ($numc >= 900 && $numc <= 999)
        {
            $numce = "NOVECIENTOS ";
            if ($numc > 900)
                $numce = $numce.(decena($numc - 900));
        }
        else if ($numc >= 800 && $numc <= 899)
        {
            $numce = "OCHOCIENTOS ";
            if ($numc > 800)
                $numce = $numce.(decena($numc - 800));
        }
        else if ($numc >= 700 && $numc <= 799)
        {
            $numce = "SETECIENTOS ";
            if ($numc > 700)
                $numce = $numce.(decena($numc - 700));
        }
        else if ($numc >= 600 && $numc <= 699)
        {
            $numce = "SEISCIENTOS ";
            if ($numc > 600)
                $numce = $numce.(decena($numc - 600));
        }
        else if ($numc >= 500 && $numc <= 599)
        {
            $numce = "QUINIENTOS ";
            if ($numc > 500)
                $numce = $numce.(decena($numc - 500));
        }
        else if ($numc >= 400 && $numc <= 499)
        {
            $numce = "CUATROCIENTOS ";
            if ($numc > 400)
                $numce = $numce.(decena($numc - 400));
        }
        else if ($numc >= 300 && $numc <= 399)
        {
            $numce = "TRESCIENTOS ";
            if ($numc > 300)
                $numce = $numce.(decena($numc - 300));
        }
        else if ($numc >= 200 && $numc <= 299)
        {
            $numce = "DOSCIENTOS ";
            if ($numc > 200)
                $numce = $numce.(decena($numc - 200));
        }
        else if ($numc >= 100 && $numc <= 199)
        {
            if ($numc == 100)
                $numce = "CIEN ";
            else
                $numce = "CIENTO ".(decena($numc - 100));
        }
    }
    else
        $numce = decena($numc);

    return $numce;
}

function miles($nummero){
    if ($nummero >= 1000 && $nummero < 2000){
        $numm = "MIL ".(centena($nummero%1000));
    }
    if ($nummero >= 2000 && $nummero <10000){
        $numm = unidad(Floor($nummero/1000))." MIL ".(centena($nummero%1000));
    }
    if ($nummero < 1000)
        $numm = centena($nummero);

    return $numm;
}

function decmiles($numdmero){
    if ($numdmero == 10000)
        $numde = "DIEZ MIL";
    if ($numdmero > 10000 && $numdmero <20000){
        $numde = decena(Floor($numdmero/1000))."MIL ".(centena($numdmero%1000));
    }
    if ($numdmero >= 20000 && $numdmero <100000){
        $numde = decena(Floor($numdmero/1000))." MIL ".(miles($numdmero%1000));
    }
    if ($numdmero < 10000)
        $numde = miles($numdmero);

    return $numde;
}

function cienmiles($numcmero){
    if ($numcmero == 100000)
        $num_letracm = "CIEN MIL";
    if ($numcmero >= 100000 && $numcmero <1000000){
        $num_letracm = centena(Floor($numcmero/1000))." MIL ".(centena($numcmero%1000));
    }
    if ($numcmero < 100000)
        $num_letracm = decmiles($numcmero);
    return $num_letracm;
}

function millon($nummiero){
    if ($nummiero >= 1000000 && $nummiero <2000000){
        $num_letramm = "UN MILLON ".(cienmiles($nummiero%1000000));
    }
    if ($nummiero >= 2000000 && $nummiero <10000000){
        $num_letramm = unidad(Floor($nummiero/1000000))." MILLONES ".(cienmiles($nummiero%1000000));
    }
    if ($nummiero < 1000000)
        $num_letramm = cienmiles($nummiero);

    return $num_letramm;
}

function decmillon($numerodm){
    if ($numerodm == 10000000)
        $num_letradmm = "DIEZ MILLONES";
    if ($numerodm > 10000000 && $numerodm <20000000){
        $num_letradmm = decena(Floor($numerodm/1000000))."MILLONES ".(cienmiles($numerodm%1000000));
    }
    if ($numerodm >= 20000000 && $numerodm <100000000){
        $num_letradmm = decena(Floor($numerodm/1000000))." MILLONES ".(millon($numerodm%1000000));
    }
    if ($numerodm < 10000000)
        $num_letradmm = millon($numerodm);

    return $num_letradmm;
}

function cienmillon($numcmeros){
    if ($numcmeros == 100000000)
        $num_letracms = "CIEN MILLONES";
    if ($numcmeros >= 100000000 && $numcmeros <1000000000){
        $num_letracms = centena(Floor($numcmeros/1000000))." MILLONES ".(millon($numcmeros%1000000));
    }
    if ($numcmeros < 100000000)
        $num_letracms = decmillon($numcmeros);
    return $num_letracms;
}

function milmillon($nummierod){
    if ($nummierod >= 1000000000 && $nummierod <2000000000){
        $num_letrammd = "MIL ".(cienmillon($nummierod%1000000000));
    }
    if ($nummierod >= 2000000000 && $nummierod <10000000000){
        $num_letrammd = unidad(Floor($nummierod/1000000000))." MIL ".(cienmillon($nummierod%1000000000));
    }
    if ($nummierod < 1000000000)
        $num_letrammd = cienmillon($nummierod);

    return $num_letrammd;
}

function convertir($numero){
    $num = str_replace(",","",$numero);
    $num = number_format($num,2,'.','');
    $cents = substr($num,strlen($num)-2,strlen($num)-1);
    $num = (int)$num;
    $numf = milmillon($num);
    return $numf;
}

function eliminar_tildes($cadena){


    //Ahora reemplazamos las letras
    $cadena = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $cadena
    );

    $cadena = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $cadena );

    $cadena = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $cadena );

    $cadena = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $cadena );

    $cadena = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $cadena );

    $cadena = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C'),
        $cadena
    );

    return $cadena;
}

function getRealIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP']))
        return $_SERVER['HTTP_CLIENT_IP'];

    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        return $_SERVER['HTTP_X_FORWARDED_FOR'];

    return $_SERVER['REMOTE_ADDR'];
}

?>
