/*
    Obtengo el sexo del 'select', para introducirlo y mostrarlo
    en unacaja de texto en el formulario 'perfil.php'.
*/
var cajaSexo = document.getElementById('cajaSexo');
function obtenerSexo(sexo) {
    cajaSexo.value = sexo.value;
}

/*
    Obtengo el sexo del 'select', para introducirlo y mostrarlo en una
    caja de texto en el formulario 'modificarUserAdmin.php'.
*/
var cajaSexoAdmin = document.getElementById('cajaSexoAdmin');
function obtenerSexoAdmin(sexoUserAdmin) {
    cajaSexoAdmin.value = sexoUserAdmin.value;
}