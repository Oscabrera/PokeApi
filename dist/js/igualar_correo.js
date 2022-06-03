$(document).ready(function () {
    $('.submit').addClass('disabled');
    //variables
    var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,}/;
    var elem3 = $('#correo');
    var elem4 = $('#correo2');
    var valprim = false;
    var confirmacion2 = "Los correos coinciden.";
    var longitud2 = "Existe un error en la estructura del correo.";
    var negacion2 = "Los correos no coinciden.";
    var vacio2 = "El correo no debe encontrarse vacío.";
    //oculto por defecto el elemento span
    var span = $(".msjp");
    span.hide();

    //función que comprueba las dos correos
    function coincideMail() {
        var valor1 = elem3.val();
        var valor2 = elem4.val();
        //muestro el span
        span.show();
        //condiciones dentro de la función
        if (valor1 != valor2) {
            span.children("span").addClass("alert alert-danger alert-dismissible fade show");
            span.children("span").text(negacion2);
            elem4.data("error", negacion2);
            elem4.removeClass("valid");
            elem4.addClass("invalid");
            $('.submit').addClass('disabled');
        }
        if (!regex.test(elem3.val().trim())) {
            span.children("span").addClass("alert alert-danger alert-dismissible fade show");
            span.children("span").text(longitud2);
            elem4.data("error", longitud2);
            elem4.removeClass("valid");
            elem4.addClass("invalid");
            $('.submit').addClass('disabled');
        }
        if (valor1.length == 0 || valor1 == "") {
            span.children("span").addClass("alert alert-danger alert-dismissible fade show");
            span.children("span").text(vacio2);
            elem4.data("error", vacio2);
            elem4.removeClass("valid");
            elem4.addClass("invalid");
            $('.submit').addClass('disabled');
        }
        if (regex.test(elem3.val().trim()) && valor1 == valor2) {
            span.children("span").removeClass("alert alert-danger alert-dismissible fade show");
            span.children("span").text("");
            $('.submit').removeClass('disabled');
        }

    }

    elem3.keyup(function () {
        coincideMail();
    });
    elem4.keyup(function () {
        coincideMail();
    });
});
