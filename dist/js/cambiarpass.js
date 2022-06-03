$(document).ready(function () {
   $('.submit').addClass('disabled');
    //variables
    var pass1 = $('#password');
    var pass2 = $('#password2');
    var cajacodigo = $('#codigo');

    var confirmacion = "Las contraseñas coinciden";
    var longitud = "La contraseña debe estar formada por mas de 6 carácteres ";
    var negacion = "Las contraseñas no coinciden";
    var vacio = "La contraseña no debe encontrarse vacía";
    var codigoVacio = "El código es necesario";
    //oculto por defecto el elemento span
    var span = $(".msjp");
    span.hide();
    //función que comprueba las dos contraseñas
    function coincidePassword() {
        var valor1 = pass1.val();
        var valor2 = pass2.val();
        var codigo = cajacodigo.val();
        //muestro el span
        span.show();
        //condiciones dentro de la función
        if (valor1 != valor2) {
          span.children("span").addClass("alert alert-danger alert-dismissible fade show");
          span.children("span").text(negacion);
          pass2.removeClass("valid");
          pass2.addClass("invalid");
         $('.submit').addClass('disabled');
        }
        if (valor1.length == 0 || valor1 == "") {
          span.children("span").addClass("alert alert-danger alert-dismissible fade show");
          span.children("span").text(vacio);
          pass2.removeClass("valid");
          pass2.addClass("invalid");
         $('.submit').addClass('disabled');
        }
        if (codigo.length == 0 || codigo == "") {
          span.children("span").addClass("alert alert-danger alert-dismissible fade show");
          span.children("span").text(codigoVacio);
          pass2.removeClass("valid");
          pass2.addClass("invalid");
           $('.submit').addClass('disabled');
        }
        if (valor1.length < 6 ) {
          span.children("span").addClass("alert alert-danger alert-dismissible fade show");
          span.children("span").text(longitud);
          pass2.removeClass("valid");
          pass2.addClass("invalid");
         $('.submit').addClass('disabled');
        }
        if (valor1.length > 5 && valor1 == valor2 && codigo.length==6) {
          span.children("span").removeClass("alert alert-danger alert-dismissible fade show");
          span.children("span").text("");
            $('.submit').removeClass('disabled');
        }

    }
    //ejecuto la función al soltar la tecla
    pass2.keyup(function () {
        coincidePassword();
    });
    pass1.keyup(function () {
        coincidePassword();
    });
    cajacodigo.keyup(function () {
        coincidePassword();
    });
});
