/* ABRIR Y CERRAR DIALOG MSG BIENVENIDA */
const modalBienvenida = document.getElementById('modalBienvenida');
const BodyScroll = document.getElementById('bodyHiper');

// 'onload' desde el body.
function abrirModalBienvenida() {
    modalBienvenida.style.display = 'flex';
    BodyScroll.style.overflowY = 'hidden';
}

// boton 'aceptar' click.
const cerrarBienvenida = document.getElementById('btnAceptBienvenida');
cerrarBienvenida.addEventListener('click', function() {
    modalBienvenida.style.display = 'none';
    BodyScroll.style.overflowY = 'auto';
});