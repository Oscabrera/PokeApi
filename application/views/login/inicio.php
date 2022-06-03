<section class="container mt-3 sombra ">
  <div class=" mt-3 pt-2 row">
    <div class=" container-fluid">
      <div class="row">
        <div class="col-md-2"></div>
        <div class="offset-md-7 col-md-3 text-right "><?=$this->session->periodo['Periodo'].'-'.$this->session->periodo['Year'];?></div>
      </div>
      <div class="panel-body sombra">
        <div class="alert alert-info  container-fluid col-xs-10 col-xs-offset-1 ">
          <div class="text-center">
            <h4>¡Bienvenido!</h4>
            <h5><?=$this->session->usuario;?></h5>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
