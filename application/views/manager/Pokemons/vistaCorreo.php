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
            margin-top: 20px;
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
      <h3><span>Datos de <?=$nombre?>:</span></h3>
      <br>
      <img src="<?=$img?>" class="card-img-top" style="height: 100px; width: 100px" alt="...">
      Altura: <?=$height?><br>
      Peso: <?=$weight?><br>
      Experiencia Base: <?=$base_experience?><br>
      <br>
      <ul>
      <?php foreach ($habilidad as $K => $V) { ?>
          <li> <?=$V[0]?>  <?=($V[1]==true) ? '(hidden)' : '' ?> </li>
      <?php }  ?>
      </ul>
      <span class="fecha">Fecha de petición: <?=FechaLetra(date('Y-m-d H:i:s'));?></span>
    </body>
</html>
