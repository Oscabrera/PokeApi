<div class="row d-flex justify-content-around">

<?php foreach($pokes as $K => $E ){ 
 $img = (array) $E->sprites->other; ?>
<div class="card m-2" style="width: 18rem;">
  <img src="<?=$img['official-artwork']->front_default?>" class="card-img-top" alt="...">
  <div class="card-body">
    <h5 class="card-title"><?=$E->name?></h5>
    <p class="card-text">
      N.º <?=sprintf("%03d", $E->id)?><br>
      Experiencia Base: <?=$E->base_experience?><br>
    </p>
    <?php if($E->interno == false){?>
      <div class="row m-2">
      <div class="col-6">
      <button type="button" data-id="<?=$E->id?>" class="btn btn-success insert">Registrar</button>
      </div>
      </div>
    <?php } else {?>
    <div class="row m-2">
      <div class="col-6"><button type="button" data-id="<?=$E->id?>" class="btn btn-primary update">Modificar</button></div>
      <div class="col-6"><button type="button" data-id="<?=$E->id?>" class="btn btn-danger delete">Eliminar</button></div>
    </div>
    <?php } ?>
    <div class="row m-2">
      <div class="col-6"><button type="button" data-id="<?=$E->id?>" class="btn btn-info send"> Enviar</button></div>
    </div>
  </div>
</div>
<?php } ?>




</div>

