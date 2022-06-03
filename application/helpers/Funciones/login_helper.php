<?php

use \Mailjet\Resources;

/* Oscar Cabrera 02/06/2018
* hashear -> genera el hash de contraseña recibe password y una fecha
*/

// hashear -> genera el hash de contraseña recibe password y una fecha
// Oscar Cabrera 02/06/2018
// Controlador Acceso
// Metodo index
function hashear($pass, $fecha_reg){
  $fecha_reg=remplazarparahash($fecha_reg);
  return hash('ripemd256', $pass.$fecha_reg);
}

function remplazarparahash($text){
  $text=str_replace('-','*',$text);
  $text=str_replace(':','&',$text);
  $text=str_replace('.','%',$text);
  $text=str_replace(' ','',$text);
  return $text;
}

function generarclavesistema($maximo = 6) {
    $caracteres = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    $clave = '';
    $totalcaracteres = strlen($caracteres);
    while ($maximo--> 0) {
        $clave .= $caracteres[mt_rand(0, $totalcaracteres-1)];
    }
    return $clave;
}

function generarToken($correo,$token){
  $recoveri = hash('ripemd256',$token->Id_Usuario.remplazarparahash($token->Fecha_Peticion).$correo);
  $recoveri = $recoveri.hash('ripemd256', $token->Codigo_validacion);
  $recoveri = hash('ripemd256', $recoveri);
  return $recoveri;
}

function enviarCorreo($correo, $vista){
    $mj = new \Mailjet\Client(
        '33980805d0b11442c0bd133c59517b41',
        'f03b19d8180e1785ce4590e69bac0d0c',true,
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

?>
