<script>
    $("#buscador").click(function (){
        let limitbuscar = $("#limitbuscar").val();
        let initbuscar = $("#initbuscar").val();
        cargarContenedor('<?=base_url()?>manager/pokedexinit','elements',{limit: limitbuscar, inicio: initbuscar });
    });
</script>