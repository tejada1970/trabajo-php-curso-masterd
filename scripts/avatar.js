/* AVATAR CERRAR SESIÓN */
const avatarCloseSesion = document.querySelectorAll('.avatarIco');

$(document).ready(function() {
    $(".avatarIco").attr("title","Cerrar Sesión");
});

avatarCloseSesion.forEach(element => {
    element.addEventListener('mouseover', () => {
        element.attr.title.textContent = '';
        element.attr.title.textContent= 'Cerrar Sesión';
    });
    element.addEventListener('click', () => {
        location.href = "../assets/archivosPHP/cerrarSesion.php";
    });
});