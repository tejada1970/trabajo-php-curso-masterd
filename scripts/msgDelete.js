/* ABRIR Y CERRAR DIALOG MSG DELETE */

// 'onload' desde el body.
const modalDelete = document.getElementById('modalDelete');
function abrirModalDelete() {
    modalDelete.style.display = 'block';
    modalDelete.showModal();
}

// boton 'aceptar' click.
const btnAcceptCerrar = document.getElementById('btnAccept');
btnAcceptCerrar.addEventListener('click', function() {
    modalDelete.close();
    modalDelete.style.display = 'none';
});

// boton 'cancelar' click.
const btnCancelCerrar = document.getElementById('btnCancel');
btnCancelCerrar.addEventListener('click', function() {
    modalDelete.close();
    modalDelete.style.display = 'none';
});