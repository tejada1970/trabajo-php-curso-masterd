// 'onload' desde el body de messages.php
const modalDialog = document.getElementById('modal');

function abrirModal() {
    modalDialog.style.display = 'block';
    modalDialog.showModal();
}

const cerrarModal = document.getElementById('btnAceptarMsg');
cerrarModal.addEventListener('click', function() {
    modalDialog.close();
    modalDialog.style.display = 'none';
});
