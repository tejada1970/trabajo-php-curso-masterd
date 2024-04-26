/* ABRIR Y CERRAR DIALOG MESSAGES */

// 'onload' desde el body.
const modalDialog = document.getElementById('modal');
function abrirModal() {
    modalDialog.style.display = 'block';
    modalDialog.showModal();
}

// boton 'aceptar' click.
const cerrarModal = document.getElementById('btnAceptarMsg');
cerrarModal.addEventListener('click', function() {
    modalDialog.close();
    modalDialog.style.display = 'none';
});