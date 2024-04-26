/*
    Obtengo el 'boton cerrar' de todos los contenedores 'containerCerrar' y
    los 'h3'de ('registro.php' y 'login.php), para resetear los formularios.
*/
const btnResetear = document.querySelectorAll('.resetear');
btnResetear.forEach(element => {
    element.addEventListener('click', function() {
        document.datos.reset();
    });
});