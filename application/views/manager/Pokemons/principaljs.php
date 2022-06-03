<script>
$(".insert").click(function(){
  let id = $(this).data('id');
  $(this).addClass('disabled');
  $.confirm({
                title: 'Guardar',
                content: '&iquest;Desea continuar con el guardado del Recurso?',
                icon: 'fa fa-question-circle',
                theme: 'supervan',
                closeIcon: true,
                animation: 'scale',
                type: 'orange',
                buttons: {
                    confirm: {
                        text: 'S&iacute;',
                        btnClass: 'btn-green',
                        action: function () {
                            $.ajax({
                                url:'<?=base_url()?>manager/actualizapokemon',
                                type: 'post',
                                dataType: 'json',
                                data: {id: id},
                                success: function (resp) {

                                    if (resp.type != 'error') {
                                      $(this).attr('disabled',true);
                                      $.confirm({
                                            title: 'Guardado',
                                            content: resp.msg,
                                            type: 'green',
                                            typeAnimated: true,
                                            buttons: {
                                                acept: {
                                                    text: 'aceptar',
                                                    btnClass: 'btn-green'
                                                }
                                            }
                                        });
                                    } else {
                                        $.confirm({
                                            title: 'Error',
                                            content: resp.msg,
                                            type: 'red',
                                            typeAnimated: true,
                                            buttons: {
                                                acept: {
                                                    text: 'aceptar',
                                                    btnClass: 'btn-green',
                                                    action: function () {
                                                      $(this).removeClass('disabled');
                                                    }
                                                }
                                            }
                                        });
                                    }
                                }
                            });
                        }
                    },
                    cancel: {
                        text: 'No',
                        btnClass: 'btn-red',
                        action: function () {
                            $(this).removeClass('disabled');
                        }
                    }
                },
                closeIcon: function () {
                  $(this).removeClass('disabled');
                }
            });

});

$(".update").click(function(){
    let id = $(this).data('id');
    $(this).addClass('disabled');
    $.confirm({
        title: 'Guardar',
        content: '&iquest;Desea continuar con la actualización del Recurso?',
        icon: 'fa fa-question-circle',
        theme: 'supervan',
        closeIcon: true,
        animation: 'scale',
        type: 'orange',
        buttons: {
            confirm: {
                text: 'S&iacute;',
                btnClass: 'btn-green',
                action: function () {
                    $.ajax({
                        url:'<?=base_url()?>manager/actualizapokemon',
                        type: 'post',
                        dataType: 'json',
                        data: {id: id},
                        success: function (resp) {

                            if (resp.type != 'error') {
                                $(this).attr('disabled',true);
                                $.confirm({
                                    title: 'Guardado',
                                    content: resp.msg,
                                    type: 'green',
                                    typeAnimated: true,
                                    buttons: {
                                        acept: {
                                            text: 'aceptar',
                                            btnClass: 'btn-green'
                                        }
                                    }
                                });
                            } else {
                                $.confirm({
                                    title: 'Error',
                                    content: resp.msg,
                                    type: 'red',
                                    typeAnimated: true,
                                    buttons: {
                                        acept: {
                                            text: 'aceptar',
                                            btnClass: 'btn-green',
                                            action: function () {
                                                $(this).removeClass('disabled');
                                            }
                                        }
                                    }
                                });
                            }
                        }
                    });
                }
            },
            cancel: {
                text: 'No',
                btnClass: 'btn-red',
                action: function () {
                    $(this).removeClass('disabled');
                }
            }
        },
        closeIcon: function () {
            $(this).removeClass('disabled');
        }
    });

});

$(".delete").click(function(){
    let id = $(this).data('id');
    $(this).addClass('disabled');
    $.confirm({
        title: 'Guardar',
        content: '&iquest;Desea continuar con la eliminación del Recurso?',
        icon: 'fa fa-question-circle',
        theme: 'supervan',
        closeIcon: true,
        animation: 'scale',
        type: 'orange',
        buttons: {
            confirm: {
                text: 'S&iacute;',
                btnClass: 'btn-green',
                action: function () {
                    $.ajax({
                        url:'<?=base_url()?>manager/borrarpokemon',
                        type: 'post',
                        dataType: 'json',
                        data: {id: id},
                        success: function (resp) {

                            if (resp.type != 'error') {
                                $(this).attr('disabled',true);
                                $.confirm({
                                    title: 'Guardado',
                                    content: resp.msg,
                                    type: 'green',
                                    typeAnimated: true,
                                    buttons: {
                                        acept: {
                                            text: 'aceptar',
                                            btnClass: 'btn-green'
                                        }
                                    }
                                });
                            } else {
                                $.confirm({
                                    title: 'Error',
                                    content: resp.msg,
                                    type: 'red',
                                    typeAnimated: true,
                                    buttons: {
                                        acept: {
                                            text: 'aceptar',
                                            btnClass: 'btn-green',
                                            action: function () {
                                                $(this).removeClass('disabled');
                                            }
                                        }
                                    }
                                });
                            }
                        }
                    });
                }
            },
            cancel: {
                text: 'No',
                btnClass: 'btn-red',
                action: function () {
                    $(this).removeClass('disabled');
                }
            }
        },
        closeIcon: function () {
            $(this).removeClass('disabled');
        }
    });

});

$(".send").click(function(){
    let id = $(this).data('id');
    $(this).addClass('disabled');
    $.confirm({
        title: 'Enviar',
        content: '&iquest;Desea continuar con el envío del Recurso?',
        icon: 'fa fa-question-circle',
        theme: 'supervan',
        closeIcon: true,
        animation: 'scale',
        type: 'orange',
        buttons: {
            confirm: {
                text: 'S&iacute;',
                btnClass: 'btn-green',
                action: function () {
                    $.ajax({
                        url:'<?=base_url()?>manager/sendemail',
                        type: 'post',
                        dataType: 'json',
                        data: {id: id},
                        success: function (resp) {
                            $.confirm({
                                title: 'Enviadó',
                                content: 'Datos en el correo',
                                type: 'green',
                                typeAnimated: true,
                                buttons: {
                                    acept: {
                                        text: 'aceptar',
                                        btnClass: 'btn-green',
                                        action: function () {
                                            $(this).removeClass('disabled');
                                        }
                                    }
                                }
                            });
                        }
                    });
                }
            },
            cancel: {
                text: 'No',
                btnClass: 'btn-red',
                action: function () {
                    $(this).removeClass('disabled');
                }
            }
        },
        closeIcon: function () {
            $(this).removeClass('disabled');
        }
    });

});


</script>
