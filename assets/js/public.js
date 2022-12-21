!(function($) {
  "use strict";  
  // Pre cargador para que se vea chulo y pro ;)
    $(window).on('load', function() {
        if ($('#preloader').length) {
            $('#preloader').delay(100).fadeOut('slow', function() {
                $(this).remove();
            });
        }
    });  
})(jQuery);

/************************ FUNCIONES DE USO GENERAL ************************/
// Funcion para solo permitir letras y un par de caracteres especiales
var lettersonly = function (e) {

    var key = (window.event) ? window.event.keyCode : e.which; // depende del navegador capturamos las pulsaciones
    var keychar = String.fromCharCode(key).toLowerCase();

    if ((key == null) || (key == 0) || (key == 8) || (key == 9) || (key == 13) || (key == 27))
        return true;

    else if ((("1234567890abcdefghtijklmnñÑopqrstuvwxyzáéíóúü._ ").indexOf(keychar) > -1))
        return true;
    else
        return false;
};