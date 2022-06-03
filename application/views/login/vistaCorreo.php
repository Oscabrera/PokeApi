<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Recuperación</title>
        <style media="screen">
          #boton{
            background-color: #33D033; /* Green */
            color: white;
            padding: 20px 30px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            border-radius: 0px;
            font-size: 22px;
            box-shadow: 0 2px 5px 0 rgba(0,0,0,.16), 0 2px 10px 0 rgba(0,0,0,.12);
            border: 0;
            margin-top: 25px;
          }

          .fecha{
            margin-top: 100px;
            display: block;
          }

          #codigo{
            background-color: #1B396A;
            box-shadow: 0 2px 5px 0 rgba(0,0,0,.16), 0 2px 10px 0 rgba(0,0,0,.12);
            color: white;
            padding: .5em;
          }
        </style>
    </head>
    <body style="text-align:left; margin-left: 10% ; margin-right: 10%;">
      <h3><span>Estimado usuario:</span></h3>
      <br>
      <h3>Estás recibiendo este correo debido a que hiciste una solicitud de obtención de contraseña para tu cuenta de la plataforma del programa <b>"Nombre de la App"<b>, necesitaras el código de seguridad</h3>
      <br>
      <h2>Código de seguridad: <span id="codigo" ><?= $token->Codigo_validacion; ?></span></h2>
      <br>
      <a type='submit' class="centered_div" id="boton" href="<?php echo base_url().'acceso/restablecer?token='.$token->Token?>"> Ir a obtener contraseña</a>
      <span class="fecha">Fecha de petición: <?=FechaLetra($token->Fecha_Peticion);?></span>
    </body>
</html>
